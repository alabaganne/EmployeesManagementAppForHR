<template>
    <edit-collaborator :role="'edit'" />
</template>

<script>
export default {
    components: {
        'edit-collaborator': () => { return import('@/components/collaborator/CreateEditCollaborator'); }
    }
}
</script>