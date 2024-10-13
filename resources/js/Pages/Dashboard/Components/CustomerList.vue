<script setup>
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    getUserCustomerList: {
        type: Array,
        required: true
    }
})

const latestCustomerHeaders = [
    { title: 'Company Name', key: 'name', sortable: false },
    { title: 'Product', key: 'orders[0].product.name', sortable: false},
    { title: 'Latest Order', key: 'orders[0].created_at', sortable: false },
    { title:'Action', key: 'actions', sortable: false }
];
</script>

<template>
    <Head title="Dashboard" />

    <v-card-text>
        <v-data-table
            :headers="latestCustomerHeaders"
            :items="props.getUserCustomerList"
            :items-per-page="5"
            class="elevation-3"
        >
            <template v-slot:item.orders[0].created_at="{ item }">
                {{ new Date(item.orders[0]?.created_at).toLocaleString('en-GB') }}
            </template>
            <template v-slot:item.actions="{ item }">
                <v-tooltip text="Go To Profile">
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
</template>
