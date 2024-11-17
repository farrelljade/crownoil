<script setup>

defineProps ({
    customer: Array,
})
</script>

<template>
    <v-card class="mb-2">
        <v-tabs
            bg-color="info"
            center-active
        >
            <v-tab>One</v-tab>
            <v-tab>Two</v-tab>
            <v-tab>Three</v-tab>
            <v-tab>Four</v-tab>
            <v-tab>Five</v-tab>
            <v-tab>Six</v-tab>
            <v-tab>Seven</v-tab>
            <v-tab>Eight</v-tab>
            <v-tab>Nine</v-tab>
        </v-tabs>
    </v-card>
</template>
