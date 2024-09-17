<script setup>
import { Head } from '@inertiajs/vue3';
import App from '@/App.vue';

const props = defineProps({
    userTargets: {
        type: Array,
        required: true
    }
});
</script>

<template>
    <Head title="User Targets" />

    <App>
       <v-container fluid>
           <v-card class="mb-2 pa-3">
                <v-card-title class="bg-primary mb-5 d-flex justify-space-between align-center">
                     User Targets
                </v-card-title>

           </v-card>
       </v-container>
    </App>
</template>
