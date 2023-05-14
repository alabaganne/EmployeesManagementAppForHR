<template>
    <div>
        <!-- Title -->
        <div class="d-flex mb-4">
            <div class="mr-auto">
                <h4 class="text-capitalize mb-0">{{ `${name}s` }}</h4>
                <h6 v-if="false"></h6> <!-- Remaining days: 15 -->
            </div>
            <button type="button" class="btn btn-sm clickable font-weight-bold" data-toggle="modal" :data-target="`#add-${name}-modal`">
                <i class="fas fa-plus fa-sm mr-1 text-primary"></i>
                <span>Add new {{ name }}</span>
            </button>
        </div>
        <!-- Modal -->
        <modal 
            :name="name" 
            role="add"
            :form="form" 
            :modalId="`add-${name}-modal`"
            @submit-event="addPending" 
        >
            <template slot="modal-body-content">
                <slot name="modal-body" />
            </template>
        </modal>
        <!-- /Modal -->
        <!-- Table -->
        <table class="table table-bordered">
            <thead>
                <th v-for="(field, index) in fields" :key="index">{{ field | clean }}</th>
                <th>Actions</th>
            </thead>
            <tbody>
                <!-- Fetched Data -->
                <template v-if="fetchedData.length > 0 || pendingData.length > 0">
                    <!-- Duplicated keys detected error solution: https://github.com/vuejs/vue/issues/7323 -->
                    <tr v-for="(row, rowIndex) in fetchedData" :key="rowIndex + 'F'" :class="{ 'bg-light': row.edited }">
                        <td v-for="(field, fieldIndex) in fields" :key="fieldIndex">{{ row[field] }}</td>
                        <td>
                            <!-- Edit Modal: Fetched -->
                            <modal 
                                :name="name" 
                                role="edit"
                                :form="form"
                                :modalData="row" 
                                :modalId="name + rowIndex + 'F'"
                                :ref="name + 'F'"
                                @submit-event="editFetched(rowIndex)"
                            >
                            <!-- F: stands for "Fetched" -->
                                <template slot="modal-body-content">
                                    <slot name="modal-body" />
                                </template>
                            </modal>
                            <!-- /Modal -->
                            <button 
                                type="button" 
                                class="btn btn-sm btn-secondary mr-1"
                                data-toggle="modal" 
                                :data-target="'#' + name + rowIndex + 'F'" 
                                @click="$refs[name + 'F'][rowIndex].loadData()"
                            >Edit</button>
                            <!-- stackoverflow refs inside v-for: https://stackoverflow.com/questions/52086128/vue-js-ref-inside-the-v-for-loop -->
                            <button type="button" class="btn btn-sm btn-danger" @click="deleteFetchedRow(fetchedData, rowIndex)">Delete</button>
                        </td>
                    </tr>
                    <!-- Pending Data -->
                    <tr class="bg-light" v-for="(row, rowIndex) in pendingData" :key="rowIndex + 'P'">
                        <td v-for="(field, fieldIndex) in fields" :key="fieldIndex">{{ row[field] }}</td>
                        <td>
                            <!-- Edit Modal: Pending -->
                            <modal
                                :name="name" 
                                role="edit" 
                                :form="form" 
                                :modalData="row" 
                                :modalId="`${name}${rowIndex}P`" 
                                :ref="name + 'P'" 
                                @submit-event="editPending(rowIndex)" 
                            >
                                <template slot="modal-body-content">
                                    <slot name="modal-body" />
                                </template>
                            </modal>
                            <!-- /Modal -->
                            <button 
                                type="button" 
                                class="btn btn-sm btn-secondary mr-1" 
                                data-toggle="modal" 
                                :data-target="`#${name + rowIndex}P`" 
                                @click="$refs[name + 'P'][rowIndex].loadData()" 
                            >Edit</button>
                            <button type="button" class="btn btn-sm btn-danger" @click="deletePendingRow(pendingData, rowIndex)">Delete</button>
                        </td>
                    </tr>
                </template>
                <tr v-else>
                    <td class="text-danger text-center font-weight-bold" :colspan="fields.length + 1">No {{ name }}s are available for this collaborator</td>
                </tr>
            </tbody>
        </table>
        <!-- /Table -->
    </div>
</template>

<script>
import axios from 'axios';
export default {
    props: {
        name: String,
        form: Object,
    },
    components: {
        modal: () => { return import('@/components/Modal') }
    },
    data() {
        return {
            fetchedData: [],
            pendingData: [],
            pendingUpdates: [],
            pendingDeletes: [], // contains the id of the elements that will be deleted
            collaboratorId: null,
        }
    },
    computed: {
        fields() {
            let keys = Object.keys(this.form);
            keys.splice(keys.indexOf('errors'), 1);
            keys.splice(keys.indexOf('originalData'), 1);
            return keys;
        }
    },
    mounted() {
        this.collaboratorId = this.$route.params.id || null;
        // fetch data if a user id is present on the URL
        if(this.collaboratorId) {
            axios.get(`/collaborators/${this.collaboratorId}/${this.name}s`).then(response => {
                this.fetchedData = response.data;
                this.fetchedData.forEach(row => {
                    row['edited'] = false;
                })
            });
        }
    },
    methods: {
        validate() {
            return new Promise((resolve) => {
                let skillExists = false;
                if(this.name == 'skill') {
                    let arraysData = this.fetchedData.concat(this.pendingData);
                    arraysData.forEach(el => {
                        if(this.form.name == el.name && (this.form.id === undefined || this.form.id !== el.id)) {
                            this.form.errors.record({
                                name: [
                                    "This collaborator already have that skill."
                                ]
                            })
                            skillExists = true;
                        }
                    })
                }
                if(!skillExists) {
                    this.form.post(`/validate/${this.name}`).then(() => {
                        resolve();
                    }).catch(error => console.log(error));
                }
            })
        },
        submit(collaboratorId) {
            // Create
            this.pendingData.forEach(row => {
                axios.post(`/collaborators/${collaboratorId}/${this.name}s`, row).catch(error => {
                    console.error(error.response);
                });
            });
            // Update
            this.pendingUpdates.forEach(row => {
                axios.put(`/collaborators/${this.collaboratorId}/${this.name}s/${row.id}`, row).catch(error => console.log(error));
            });
            // Delete
            this.pendingDeletes.forEach(value => {
                axios.delete(`/collaborators/${this.collaboratorId}/${this.name}s/${value}`).catch(error => console.log(error));
            });
        },
        // Store newly created items in cache until user submit the user creation/updatte Form
        addPending() {
            this.validate().then(() => {
                this.pendingData.push(this.form.data());
                this.clearForm();
            });
        },
        // Edit items stored in the cache
        editPending(index) {
            this.validate().then(() => { this.editInterfaceData(this.pendingData, index); });
        },
        editFetched(index) {
            this.validate().then(() => {
                this.fetchedData[index].edited = true;
                this.editInterfaceData(this.fetchedData, index);
                let temp = {};
                Object.assign(temp, this.fetchedData[index]);
                delete temp.edited;

                let duplicatedPendingUpdateIndex = this.checkForDuplicates(this.pendingUpdates, temp); // prevent duplication

                if(duplicatedPendingUpdateIndex !== null) this.pendingUpdates[duplicatedPendingUpdateIndex] = temp;
                else this.pendingUpdates.push(temp);
            });
        },
        clearForm() {
            this.form.clear();
            this.form.errors.clear();
        },
        checkForDuplicates(table, element) {
            let duplicationPosition = null;
            table.forEach((tableElement, index) => {
                if(tableElement.id === element.id) {
                    duplicationPosition = index;
                }
            });
            return duplicationPosition;
        },
        editInterfaceData(table, index) {
            this.fields.forEach(key => {
                table[index][key] = this.form.data()[key];
            });
        },
        // Deleting
        deletePendingRow(table, index) { // table: pending data Array
            table.splice(index, 1);
        },
        deleteFetchedRow(table, index) { // table: fetched data Array
            this.pendingDeletes.push(table[index].id);
            table.splice(index, 1)
        }
    },
}
</script>

<style scoped>
    .form-control, .custom-select {
        border-radius: 0;
    }
</style>