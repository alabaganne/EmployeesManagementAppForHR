<template>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th v-for="(field, index) in fields" :key="index">{{ field | clean }}</th>
                <th v-if="name === 'collaborator'">Actions</th>
            </tr>
        </thead>
        <tbody>
            <template v-if="dataTable.length > 0">
                <tr v-for="(row, rowIndex) in dataTable" :key="row.id">
                    <td v-for="(field, fieldIndex) in fields" :key="fieldIndex">{{ row[field] }}</td>
                    <td v-if="name === 'collaborator'">
                        <a href="#" class="btn btn-sm btn-secondary mr-1" @click="restore(rowIndex)">Restore</a>
                        <a href="#" class="btn btn-sm btn-danger" @click="deletePermantly(rowIndex)">Delete permantly</a>
                    </td>
                </tr>
            </template>
            <tr v-else>
                <th :colspan="fields.length + 1" class="text-center text-danger">
                    <template v-if="name === 'collaborator'">There's no archived collaborators.</template>
                    <template v-else>
                        <template v-if="user.id !== $route.params.id">This collaborator has no {{ name }}s.</template>
                        <template v-else>You have no {{ name }}s.</template>
                    </template>
                </th>
            </tr>
        </tbody>
    </table>
</template>

<script>
import axios from 'axios';
import { mapGetters } from 'vuex'
export default {
    props: {
        name: String,
        fields: Array,
        dataTable: Array,
    },
    computed: {
        ...mapGetters({
            user: "auth/user"
        })
    },
    methods: {
        restore(index) {
            axios.get(`/collaborators/${this.dataTable[index].id}/restore`).then(() => {
                this.dataTable.splice(index,1);
            })
        },
        deletePermantly(index) {
            axios.delete(`/collaborators/${this.dataTable[index].id}/delete-permantly`).then(() => {
                this.dataTable.splice(index, 1);
            }).catch(error => {
                console.log(error);
            });
        },
    }
}
</script>