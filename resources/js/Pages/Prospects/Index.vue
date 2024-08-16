<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage} from '@inertiajs/vue3';
import { ref, defineAsyncComponent, computed } from 'vue';

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
    user_id: null
});

const tableData = computed(() => {
    return props.prospects.filter(prospect => {
        return (!params.value.lead_source_id || prospect.lead_source_id === params.value.lead_source_id)
            && (!params.value.user_id || prospect.user_id === params.value.user_id);
    });
});

function resetFilters() {
    params.value.lead_source_id = null;
}

const latestProspectsHeaders = [
    { title: 'Company Name', key: 'name', sortable: false },
    { title: 'Lead Source', key: 'lead_source.name', sortable: false },
    { title: 'Assigned User', key: 'user.name', sortable: false },
    { title: 'Action', key: 'actions', sortable: false }
];

</script>

<template>
    <Head title="Prospects" />

    <AuthenticatedLayout>
        <v-container>
            <v-card class="mb-2">
                <v-card-title class="bg-primary mb-5">
                    Prospects
                </v-card-title>

                <v-card-text class="mb-4">
                    <v-row>
                        <v-col cols="6" md="3" class="pb-0">
                            <v-autocomplete
                                class="mt-2"
                                density="compact"
                                v-model="params.user_id"
                                label="Assigned User"
                                :items="users"
                                item-value="id"
                                item-title="name"
                                hide-details
                                clearable
                            />
                        </v-col>
                        <v-col cols="6" md="3" class="pb-0">
                            <v-autocomplete
                                class="mt-2"
                                density="compact"
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
            
            <v-card id="prospectTableData">
                <v-card-text>
                    <v-data-table
                        :headers="latestProspectsHeaders"
                        :items="tableData"
                        class="elevation-3"
                        id="prospectTable"
                    >
                        <template v-slot:item.lead_source="{ item }">
                            <span>
                                {{ item.lead_source }}
                            </span>
                        </template>
                        <template v-slot:item.actions="{ item }">
                            <v-tooltip text="Go To Profile" bottom>
                                <template v-slot:activator="{ props }">
                                    <v-icon
                                        class="mr-2"
                                        color="green"
                                        :="{ props }"
                                    >
                                    mdi-location-enter
                                    </v-icon>
                                </template>
                            </v-tooltip>
                        </template>
                    </v-data-table>
                </v-card-text>
            </v-card>
        </v-container>
    </AuthenticatedLayout>
</template>