<script setup>
import { Head, Link } from '@inertiajs/vue3';
import App from '@/App.vue';
import CustomVTextField from "@/Components/CustomVTextField.vue";
import {computed, ref} from "vue";
import CustomVAutocomplete from "@/Components/CustomVAutocomplete.vue";

const props = defineProps({
    users: {
        type: Array,
        required: true
    }
});

const params = ref({
    user_id: null
});

const tableData = computed(() => {
    return props.users.filter(user => {
        return (!params.value.user_id || user.id === params.value.user_id);
    });
});

const usersHeaders = [
    { title: 'User Name', key: 'name', sortable: false },
    { title: 'Manager', key: 'manager.name', sortable: false },
    { title: 'Email', key: 'email', sortable: false },
    { title: 'Action', key: 'actions', sortable: false }
];

</script>

<template>
    <Head title="account" />

    <App>
        <v-container fluid>
            <v-card class="mb-2 pa-3">
                <v-card-title class="bg-primary mb-5 d-flex justify-space-between align-center">
                    Users
                    <v-tooltip text="Add New account!!!!!">
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
                            <CustomVAutocomplete
                                class="mt-2"
                                v-model="params.user_id"
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

            <v-card>
                <v-card-text>
                    <v-data-table
                        :headers="usersHeaders"
                        :items="tableData"
                        class="elevation-3"
                    >
                        <template v-slot:item.actions="{ item }">
                            <v-tooltip text="Go To Profile" bottom>
                                <template v-slot:activator="{ props }">
                                    <Link :href="route('dashboard.user', item.id)">
                                        <v-icon color="green" v-bind="props">
                                            mdi-location-enter
                                        </v-icon>
                                    </Link>
                                </template>
                            </v-tooltip>
                            <v-tooltip text="Edit Profile">
                                <template v-slot:activator="{ props }">
                                    <Link :href="route('users.show', item.id)">
                                        <v-icon color="orange" v-bind="props" class="ml-2">
                                            mdi-pencil
                                        </v-icon>
                                    </Link>
                                </template>
                            </v-tooltip>
                        </template>
                    </v-data-table>
                </v-card-text>
            </v-card>
        </v-container>
    </App>
</template>
