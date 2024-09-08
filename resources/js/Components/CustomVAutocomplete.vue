<template>
    <v-autocomplete
        :="$attrs"
        @="$listeners"
        variant="solo"
    />
</template>

<script>
export default {
    name: 'CustomVAutocomplete',
};
</script>

<style scoped>
::v-deep(.v-field--variant-solo) {
    border-radius: 5px;
}
</style>
