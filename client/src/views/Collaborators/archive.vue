<template>
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <h1 class="text-center bg-dark light-linear-gradient text-warning text-shadow display-4 mb-0 p-4">Archive</h1>
        <div class="p-5">
            <div class="d-flex align-items-center mb-4">
                <div class="mr-auto">
                    <select class="form-control" v-model="itemsPerPage" @change="changeItemsPerPageValue">
                        <option v-for="index in 7" :key="index" v-bind:value="5 + index">{{ 5 + index }}</option>
                    </select>
                </div>
                <form style="width: 350px;" @submit.prevent="search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Collaborator's name" v-model="searchInput">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-dark">Seach</button>
                        </div>
                    </div>
                </form>
            </div>
            <show-data-table class="mb-4" :name="'collaborator'" :fields="['id', 'name', 'deleted_at']" :dataTable="collaborators" />
            <div class="d-flex justify-content-center">
                <div>
                    <button 
                        class="btn btn-sm rounded btn-primary mr-2" 
                        v-on:click="previousPage" 
                        :disabled="currentPage === 1"
                    >previous</button>
                    <button class="btn btn-sm mr-2" disabled>{{ `${currentPage} of ${lastPage}` }}</button>
                    <button 
                        class="btn btn-sm rounded btn-primary" 
                        v-on:click="nextPage" 
                        :disabled="currentPage >= lastPage"
                    >
                        next
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import collaboratorMixin from '@/mixins/collaboratorMixin';
export default {
    mixins: [collaboratorMixin],
    components: {
        'show-data-table': () => { return import('@/components/collaborator/ShowDataTable') }
    },
    data() {
        return {
            collaborators: [],
            itemsPerPage: 8,
            currentPage: 1,
            lastPage: 0,
            searchInput: '',
        }
    },
    mounted() {
        this.getCollaborators()
    },
    methods: {
        getCollaborators() {
            this.fetchCollaborators(this.itemsPerPage, this.currentPage, this.searchInput, true).then(response => {
                this.collaborators = response.data.data;
                this.lastPage = response.data.meta.last_page;
            });
        },
        previousPage() {
            this.currentPage--;
            this.getCollaborators();
        },
        nextPage() {
            this.currentPage++;
            this.getCollaborators();
        },
        changeItemsPerPageValue() {
            this.currentPage = 1;
            this.getCollaborators();
        },
        search() {
            this.currentPage = 1;
            this.getCollaborators()
        }
    }
}
</script>

<style>
@media (min-width: 990px) and (max-width: 1225px), (max-width: 815px) {
    table { font-size: 10pt; }
    .p-5 {
        padding-left: 1em !important;
        padding-right: 1em !important;
    }
}
</style>