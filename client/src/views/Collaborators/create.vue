<template>
    <!-- 2 Roles for this component: create & edit -->
    <create-collaborator :role="'create'" />
</template>

<script>
export default {
    components: {
        'create-collaborator': () => { return import('@/components/collaborator/CreateEditCollaborator.vue') }
    }
}
</script>