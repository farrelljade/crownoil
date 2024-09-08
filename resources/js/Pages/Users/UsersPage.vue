<script setup>
import { Head, Link } from '@inertiajs/vue3';
import App from '@/App.vue';
import CustomVTextField from "@/Components/CustomVTextField.vue";

const props = defineProps({
    users: {
        type: Array,
        required: true
    }
});
</script>

<template>
    <Head title="Users" />

    <App>
        <v-container fluid>
            <v-card class="mb-2 pa-3">
                <v-card-title class="bg-primary mb-5 d-flex justify-space-between align-center">
                    Users
                    <v-tooltip text="Add New User">
                        <template v-slot:activator="{ props }">
                            <v-btn
                                density="compact"
                                icon="mdi-plus"
                                color="primary"
                                v-bind="props"
                                @click="dialog = true"
                            >
                            </v-btn>
                        </template>
                    </v-tooltip>
                </v-card-title>

                <v-card-text>
                    <v-row>
                        <v-col cols="12" md="3">
                            <CustomVTextField
                                class="mt-2"

                                label="User Name"
                                :items="users"
                                item-value="id"
                                item-title="name"
                                hide-details
                                clearable
                            />
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-container>
    </App>
</template>
