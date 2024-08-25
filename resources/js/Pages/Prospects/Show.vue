<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import App from '@/App.vue';

const props = defineProps({
    prospect: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <Head :title="'Profile - ' + prospect.name" />

    <App>
        <v-container fluid>
            <v-card class="mb-2 pa-3" style="max-width: 600px">
                <v-card-title class="bg-primary mb-5 d-flex justify-space-between align-center">
                    Contact Details: {{ prospect.name }}
                </v-card-title>

                <v-card-text>
                    <v-row class="elevation-3">
                        <v-col cols="12" md="6">
                            <v-text-field
                                prepend-icon="mdi-home-floor-1"
                                label="Line 1"
                                v-model="prospect.address.line_1"
                                readonly
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-text-field
                                prepend-icon="mdi-home-floor-2"
                                label="Line 2"
                                v-model="prospect.address.line_2"
                                :readonly="!!prospect.address.line_2"
                                :disabled="!prospect.address.line_2"
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-text-field
                                prepend-icon="mdi-city"
                                label="City"
                                v-model="prospect.address.city"
                                readonly
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-text-field
                                prepend-icon="mdi-image-area"
                                label="County"
                                v-model="prospect.address.county"
                                :readonly="!!prospect.address.county"
                                :disabled="!prospect.address.county"
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-text-field
                                prepend-icon="mdi-post"
                                label="Postcode"
                                v-model="prospect.address.postcode"
                                readonly
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-text-field
                                prepend-icon="mdi-phone"
                                label="Tel"
                                v-model="prospect.number"
                                readonly
                            />
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-text-field
                                prepend-icon="mdi-email"
                                label="Email"
                                v-model="prospect.email"
                                readonly
                            />
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-container>
    </App>
</template>
