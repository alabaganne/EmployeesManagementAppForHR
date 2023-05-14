<template>
    <div class="modal fade" :id="modalId" style="padding-left: 17px;" tabindex="-1" role="dialog" aria-hidden="true">
        <form autocomplete="off" @keydown="form.errors.clear($event.target.name)">
        <!-- <form autocomplete="off"> -->
            <div class="modal-dialog" role="document">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-primary light-linear-gradient border-bottom-0">
                        <h3 class="modal-title text-light text-shadow font-weight-bold">{{ role === 'edit' ? 'Edit' : 'Add new' }} {{ name }}</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <slot name="modal-body-content" />
                    </div>
                    <div class="modal-footer">
                        <div class="ml-auto">
                            <button type="button" class="btn rounded-sm btn-sm px-3 py-2 mr-1 btn-dark" data-dismiss="modal" @click="form.clear(); form.errors.clear()">Close</button>
                            <!-- <button type="button" class="btn rounded-sm btn-sm px-3 py-2 btn-primary">Add</button> -->
                            <button 
                                type="button" 
                                class="btn rounded-sm btn-sm px-3 py-2 btn-primary" 
                                @click="onSave" 
                                :disabled="form.errors.any()"
                            >{{ role === 'edit' ? 'Edit' : 'Add' }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    props: {
        modalId: String,
        role: String,
        name: String,
        form: Object,
        modalData: Object,
    },
    methods: {
        loadData() {
            Object.keys(this.modalData).forEach(key => {
                this.form[key] = this.modalData[key];
            });
        },
        onSave() {
            this.edited = true;
            this.$emit('submit-event'); 
        },
    },
}
</script>

<style>

</style>