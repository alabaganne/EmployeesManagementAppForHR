<template>
    <div>
        <div class="bg-white shadow-sm rounded-lg w-100 p-4">
            <div class="d-md-flex mb-3 small text-secondary">
                <router-link :to="{ name: 'add collaborator' }" class="btn clickable mr-auto font-weight-bold">
                    <i class="fas fa-plus fa-sm mr-2 text-primary"></i>Add new collaborator
                </router-link>
                <form autocomplete="off" class="pr-2" v-on:submit.prevent="findCollaboratorByName">
                    <div class="input-group">
                        <input 
                            class="form-control bg-light"
                            type="text" 
                            name="searchInput" 
                            placeholder="Search by name" 
                            style="width: 300px" 
                            v-model="searchInput"
                        >
                        <div class="input-group-append">
                            <button class="btn btn-dark">Search</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="grid-container grid-container-sm mb-4">
                <!-- display fetched collaborators -->
                <router-link class="grid h-100" v-for="collaborator in collaborators" :key="collaborator.id" :to="{ name: 'profile', params: { id: collaborator.id } }">
                    <collaboratorCard
                        class="h-100"
                        :name="collaborator.name"
                        :department="collaborator.department_name"
                        :imagePath="collaborator.image_path"
                    />
                </router-link>
            </div>
            <div class="d-flex justify-content-center">
                <div>
                    <button 
                        class="btn btn-sm btn-outline-dark rounded-pill mr-2" 
                        v-on:click="previousPage" 
                        :disabled="currentPage === 1"
                    >previous</button>
                    <button class="btn btn-sm mr-2" disabled>{{ `${currentPage} of ${lastPage}` }}</button>
                    <button 
                        class="btn btn-sm btn-outline-dark rounded-pill" 
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
import collaboratorMixin from '../../mixins/collaboratorMixin';
export default {
    mixins: [collaboratorMixin],
    components: {
        collaboratorCard: () => {
            return import('../../components/collaborator/CollaboratorCard');
        }
    },
    data() {
        return {
            collaborators: [],
            currentPage: 1,
            lastPage: null,
            searchInput: '',
        }
    },
    methods: {
        getCollaborators() {
            this.fetchCollaborators(8, this.currentPage, this.searchInput).then(response => {
                this.collaborators = response.data.data;
                this.lastPage = response.data.meta.last_page;
            });
        },
        previousPage() {
            this.currentPage--;
            this.getCollaborators()
        },
        nextPage() {
            this.currentPage++;
            this.getCollaborators()
        },
        findCollaboratorByName() {
            this.currentPage = 1;
            this.getCollaborators();
        }
    },
    mounted() {
        this.getCollaborators();
    }
}
</script>