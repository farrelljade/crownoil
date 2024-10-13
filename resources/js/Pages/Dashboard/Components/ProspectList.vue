<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import {computed, ref} from 'vue';
import AddProspect from "@/Pages/Prospects/Components/AddProspect.vue";

const dialog = ref(false);

const { props: pageProps } = usePage();

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
    }
});

const tableData = computed(() => {
    return props.prospects.map(prospect => {
        return {
            id: prospect.id,
            name: prospect.name,
            lead_source: prospect.lead_source.name,
            number: prospect.number
        };
    });
});

const latestProspectsHeaders = [
    { title: 'Company Name', key: 'name', sortable: false },
    { title: 'Lead Source', key: 'lead_source', sortable: false },
    { title: 'Contact', key: 'number', sortable: false },
    { title: 'Action', key: 'actions', sortable: false }
];
</script>

<template>
    <Head title="Prospects" />

    <v-card-text>
        <v-data-table
            :headers="latestProspectsHeaders"
            :items="tableData"
            :items-per-page="5"
            class="elevation-3"
        >
            <template v-slot:item.actions="{ item }">
                <v-tooltip text="Go To Profile" left>
                    <template v-slot:activator="{ props }">
                        <Link :href="route('prospects.show', item.id)">
                            <v-icon color="green" :="props">
                                mdi-location-enter
                            </v-icon>
                        </Link>
                    </template>
                </v-tooltip>
            </template>
        </v-data-table>
    </v-card-text>

    <v-dialog v-model="dialog" max-width="auto">
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
</template>
