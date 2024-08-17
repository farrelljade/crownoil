<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    prospect: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <Head :title="'Profile - ' + prospect.name" />

    <AuthenticatedLayout>
        <v-container>
            <v-card class="mb-2">
                <v-card-title class="bg-primary mb-5">
                    Profile: {{ prospect.name }}
                </v-card-title>
                <v-card-text>
                    <p>User: {{ prospect.user.name }}</p>
                    <p>Lead Source: {{ prospect.lead_source.name }}</p>
                    <p>Email: {{ prospect.user.email }}</p>
                </v-card-text>
            </v-card>
        </v-container>
    </AuthenticatedLayout>
</template>