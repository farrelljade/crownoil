<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const { props: pageProps } = usePage();

const user = computed(() => pageProps.auth.user);

const props = defineProps({
    prospects: {
        type: Array,
        required: true
    }
});

const tableData = computed(() => {
    return props.prospects.map(prospect => {
        return {
            id: prospect.id,
            name: prospect.name,
            lead_source: prospect.lead_source.name
        };
    });
});

const latestProspectsHeaders = [
    { title: 'Company Name', key: 'name', sortable: false },
    { title: 'Lead Source', key: 'lead_source', sortable: false },
    { title: 'Action', key: 'actions', sortable: false }
];
</script>

<template>
    <Head title="Prospects" />
    <v-container>
        <v-card class="mb-2 pa-3" style="max-width: 800px">
            <v-card-title class="bg-primary mb-5 d-flex justify-space-between align-center">
                <span>Prospects - {{ user.name }}</span>
                <v-tooltip text="Add Prospect">
                    <template v-slot:activator="{ props }">
                        <v-icon color="white" :="props">
                            mdi-plus
                        </v-icon>
                    </template>
                </v-tooltip>
            </v-card-title>
        
            <v-card-text>
                <v-data-table
                    :headers="latestProspectsHeaders"
                    :items="tableData"
                    :items-per-page="5"
                    class="elevation-3"
                >
                    <template v-slot:item.lead_source="{ item }">
                        {{ item.lead_source }}
                    </template>

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
        </v-card>
    </v-container>
</template>
