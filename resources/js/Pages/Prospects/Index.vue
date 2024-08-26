<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import App from '@/App.vue';
import AddProspect from '@/Pages/Prospects/Components/AddProspect.vue';

const dialog = ref(false);

const props = defineProps({
    prospects: {
        type: Array,
        required: true
    },
    filters: {
        type: Object,
        required: true
    },
    users: {
        type: Array,
        required: true
    },
    leadSource: {
        type: Array,
        required: true
    }
});

const params = ref({
    lead_source_id: null,
    user_id: null,
    name: null
});

const tableData = computed(() => {
    return props.prospects.filter(prospect => {
        return (!params.value.lead_source_id || prospect.lead_source_id === params.value.lead_source_id)
            && (!params.value.user_id || prospect.user_id === params.value.user_id)
            && (!params.value.name || prospect.name === params.value.name);
    });
});

const latestProspectsHeaders = [
    { title: 'Company Name', key: 'name', sortable: false },
    { title: 'Lead Source', key: 'lead_source.name', sortable: false },
    { title: 'Assigned User', key: 'user.name', sortable: false },
    { title: 'Action', key: 'actions', sortable: false }
];
</script>

<template>
    <Head title="Prospects" />

    <App>
        <v-container fluid>
            <v-card class="mb-2 pa-3">
                <v-card-title class="bg-primary mb-5 d-flex justify-space-between align-center">
                    <span>Prospects</span>
                    <v-tooltip text="Add Prospect">
                        <template v-slot:activator="{ props }">
                            <v-btn
                                density="compact"
                                color="primary"
                                icon="mdi-plus"
                                :="props"
                                @click="dialog = true"
                            >
                            </v-btn>
                        </template>
                    </v-tooltip>
                </v-card-title>

                <v-card-text>
                    <v-row>
                        <v-col cols="6" md="3">
                            <v-autocomplete
                                class="mt-2"
                                v-model="params.name"
                                label="Company Name"
                                :items="prospects"
                                item-value="id"
                                item-title="name"
                                hide-details
                                clearable
                            />
                        </v-col>
                        <v-col cols="6" md="3">
                            <v-autocomplete
                                class="mt-2"
                                v-model="params.user_id"
                                label="Assigned User"
                                :items="users"
                                item-value="id"
                                item-title="name"
                                hide-details
                                clearable
                            />
                        </v-col>
                        <v-col cols="6" md="3">
                            <v-autocomplete
                                class="mt-2"
                                v-model="params.lead_source_id"
                                label="Lead Source"
                                :items="leadSource"
                                item-value="id"
                                item-title="name"
                                hide-details
                                clearable
                            />
                        </v-col>

                        <v-col>
                            <!-- v-text-field (ref nums, id etc) -->
                        </v-col>

                        <v-col>
                            <!-- date-picker (from date and to date) -->
                        </v-col>

                        <v-col>
                            <!-- v-btn -->
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>

            <v-card>
                <v-card-text>
                    <v-data-table
                        :headers="latestProspectsHeaders"
                        :items="tableData"
                        class="elevation-3"
                    >
                        <template v-slot:item.name="{ item }">
                            {{ item.name }}
                        </template>
                        <template v-slot:item.lead_source="{ item }">
                            {{ item.lead_source }}
                        </template>
                        <template v-slot:item.actions="{ item }">
                            <v-tooltip text="Go To Profile" bottom>
                                <template v-slot:activator="{ props }">
                                    <Link :href="route('prospects.show', item.id)">
                                        <v-icon color="green" v-bind="props">
                                            mdi-location-enter
                                        </v-icon>
                                    </Link>
                                </template>
                            </v-tooltip>
                        </template>
                    </v-data-table>
                </v-card-text>
            </v-card>
        </v-container>

        <v-dialog v-model="dialog" max-width="900px">
            <v-card>
                <v-card-title class="bg-primary mb-5 d-flex justify-space-between align-center">
                    <span class="headline">New Prospect</span>
                </v-card-title>
                <v-card-text>
                    <AddProspect @close="dialog = false" :leadSource="leadSource" :users="users" />
                </v-card-text>
            </v-card>
        </v-dialog>
    </App>
</template>

