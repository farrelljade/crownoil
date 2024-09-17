<script setup>
import {Head, useForm} from '@inertiajs/vue3';
import App from "@/App.vue";
import CustomVTextField from "@/Components/CustomVTextField.vue";
import CustomVAutocomplete from "@/Components/CustomVAutocomplete.vue";
import {computed} from "vue";
import { format } from 'date-fns';

const props = defineProps({
    user: {
        type: Object,
        required: true
    },
    managers: {
        type: Array,
        required: true
    }
});

const formattedDate = computed(() => {
    return format(new Date(props.user.created_at), 'dd/MM/yyyy');
});

const form = useForm({
    manager_id: props.user.manager_id
});

const updateManager = () => {
    form.put(route('users.update', props.user.id), {
    });
};
</script>

<template>
    <Head :title="'Profile - ' + user.name" />

    <App>
        <v-container fluid>
            <v-row>
                <v-col cols="12" md="6">
                    <v-card>
                        <v-card-title class="bg-primary mb-5 d-flex justify-space-between align-center">
                            {{ user.name }}
                        </v-card-title>
                        <v-card-text>
                            <v-row class="elevation-3">
                                <v-col cols="12" md="6">
                                    <CustomVTextField
                                        prepend-icon="mdi-email"
                                        label="Email"
                                        v-model="user.email"
                                        readonly
                                    />
                                </v-col>
                                <v-col cols="12" md="6">
                                    <CustomVTextField
                                        prepend-icon="mdi-calendar"
                                        label="Start Date"
                                        v-model="formattedDate"
                                        readonly
                                    />
                                </v-col>
                                <v-col cols="12" md="6">
                                    <CustomVAutocomplete
                                        prepend-icon="mdi-account-tie"
                                        label="Manager"
                                        v-model="form.manager_id"
                                        :items="managers"
                                        item-value="id"
                                        item-title="name"
                                    />
                                </v-col>
                                <v-row>
                                    <v-col cols="12">
                                        <v-btn color="primary" @click="updateManager">Update Manager</v-btn>
                                    </v-col>
                                </v-row>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-col>

                <v-col cols="12" md="6">
                    <v-card>
                        <v-card-title class="bg-primary mb-5 d-flex justify-space-between align-center">
                            Permissions
                        </v-card-title>
                        <v-row>
                            <v-col cols="12" md="4" sm="4">
                                <v-checkbox
                                    color="success"
                                    label="Admin"
                                    value="admin"
                                ></v-checkbox>
                            </v-col>
                        </v-row>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </App>
</template>
