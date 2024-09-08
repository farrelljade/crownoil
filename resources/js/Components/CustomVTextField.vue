<template>
    <v-text-field
        :="$attrs"
        @="$listeners"
        variant="solo"
    />
</template>

<script>
export default {
    name: 'CustomVTextField',
};
</script>

<style scoped>
::v-deep(.v-field--variant-solo) {
    border-radius: 5px;
}
</style>

