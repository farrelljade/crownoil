<script setup>
import { Head, Link } from '@inertiajs/vue3';
import {computed, defineAsyncComponent, ref} from 'vue';
import App from '@/App.vue';
import AddProspect from '@/Pages/Prospects/Components/AddProspect.vue';
import CustomVAutocomplete from "@/Components/CustomVAutocomplete.vue";
import { Inertia } from "@inertiajs/inertia";
import ConfirmDialog from "@/Components/ConfirmDialog.vue";

const dialog = ref(false);
const selectedProspects = ref([]);
const reassignDialog = ref(false);
const confirmReassignDialog = ref(false);
const newUserId = ref(null);

const props = defineProps({
    prospects: {
        type: Array,
        required: true
    },
    users: {
        type: Array,
        required: true
    },
    leadSource: {
        type: Array,
        required: true
    },
    prospectName: {
        type: Array,
        required: true
    }
});

const params = ref({
    lead_source_id: null,
    user_id: null,
    prospect_name: null
});

const tableData = computed(() => {
    return props.prospects.filter(item => {
        return (!params.value.prospect_name || item.name === params.value.prospect_name)
            && (!params.value.user_id || item.user_id === params.value.user_id)
            && (!params.value.lead_source_id || item.lead_source_id === params.value.lead_source_id);
    });
});

const latestProspectsHeaders = [
    { title: 'Company Name', key: 'name', sortable: false },
    { title: 'Assigned User', key: 'user.name', sortable: false },
    { title: 'Lead Source', key: 'lead_source.name', sortable: false },
    { title: 'Action', key: 'actions', sortable: false }
];

const openReassignDialog = () => {
    reassignDialog.value = true;
};

const submitReassignment = () => {
    const prospectIds = selectedProspects.value;

    Inertia.post(route('prospects.reassign'), {
        prospect_ids: prospectIds,
        new_user_id: newUserId.value
    }, {
        onSuccess: () => {
            selectedProspects.value = [];
            newUserId.value = null;
        }
    });
};

const openConfirmDialog = () => {
    if (!newUserId.value) {
        return;
    }

    reassignDialog.value = false;
    confirmReassignDialog.value = true;
};

const confirmReassign = () => {
    submitReassignment();
    confirmReassignDialog.value = false;
};

const cancelReassign = () => {
    confirmReassignDialog.value = false;
};
</script>

<template>
    <Head title="Prospects" />

    <App>
        <v-container fluid>
            <v-card class="mb-2 pa-3">
                <v-card-title class="bg-primary mb-5 d-flex justify-space-between align-center">
                    Prospects
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
                            <CustomVAutocomplete
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
                            <CustomVAutocomplete
                                class="mt-2"
                                v-model="params.prospect_name"
                                label="Company Name"
                                :items="prospectName"
                                item-value="name"
                                item-title="name"
                                hide-details
                                clearable
                            />
                        </v-col>
                        <v-col cols="6" md="3">
                            <CustomVAutocomplete
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
                    <v-btn
                        class="mb-2"
                        color="primary"
                        :disabled="selectedProspects.length === 0"
                        @click="openReassignDialog"
                    >
                        Reassign
                    </v-btn>

                    <v-data-table
                        :headers="latestProspectsHeaders"
                        :items="tableData"
                        class="elevation-3"
                        show-select
                        v-model="selectedProspects"
                        item-key="id"
                    >
                        <template v-slot:header.data-table-select="{ allSelected, selectAll, someSelected }">
                            <v-checkbox-btn
                                :indeterminate="someSelected && !allSelected"
                                :model-value="allSelected"
                                color="primary"
                                @update:model-value="selectAll(!allSelected)"
                            ></v-checkbox-btn>
                        </template>

                        <template v-slot:item.data-table-select="{ internalItem, isSelected, toggleSelect }">
                            <v-checkbox-btn
                                :model-value="isSelected(internalItem)"
                                color="primary"
                                @update:model-value="toggleSelect(internalItem)"
                            ></v-checkbox-btn>
                        </template>

                        <template v-slot:item.name="{ item }">
                            {{ item.name }}
                        </template>
                        <template v-slot:item.user.name="{ item }">
                            {{ item.user.name }}
                        </template>
                        <template v-slot:item.lead_source="{ item }">
                            {{ item.lead_source.name }}
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
                    <AddProspect
                        @close="dialog = false"
                        :leadSource="leadSource"
                        :users="users"
                    />
                </v-card-text>
            </v-card>
        </v-dialog>

        <v-dialog v-model="reassignDialog" max-width="500px">
            <v-card>
                <v-card-title class="bg-primary mb-5 d-flex justify-space-between align-center">
                    <span class="headline">Reassign Prospects</span>
                </v-card-title>
                <v-card-text>
                    <CustomVAutocomplete
                        v-model="newUserId"
                        label="Select New User"
                        :items="users"
                        item-value="id"
                        item-title="name"
                        hide-details
                        clearable
                    />
                </v-card-text>
                <v-card-actions>
                    <v-btn @click="reassignDialog = false">Cancel</v-btn>
                    <v-btn color="primary" @click="openConfirmDialog">Reassign</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog v-model="confirmReassignDialog" max-width="500px">
            <ConfirmDialog
                text="Are you sure you want to reassign the selected prospect(s)?"
                @onCancel="cancelReassign"
                @confirm="confirmReassign"
            />
        </v-dialog>
    </App>
</template>
