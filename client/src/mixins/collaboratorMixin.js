import axios from 'axios';
export default {
    methods: {
        // search
        fetchCollaborators(itemsPerPage = 8, currentPageUrl = 1, searchInput = "", archive = false) {
            let payload = {
                'search_text': searchInput,
                'items_per_page': itemsPerPage
            }
            return new Promise(resolve => {
                let url = `/collaborators?page=${currentPageUrl}`
                if(archive) {
                    url = `/collaborators/archive?page=${currentPageUrl}`;
                }
                axios.post(url, payload).then(response => {
                    resolve(response);
                }).catch(error => {
                    console.log(error.response);
                })
            })
        },
    }
}