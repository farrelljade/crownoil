<script setup>
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';
import AddOrder from "@/Pages/Orders/Components/AddOrder.vue";
import {computed, ref} from "vue";

const dialog = ref(false);

const props = defineProps({
    getUserOrders: {
        type: Array,
        required: true
    },
    getUserCustomers: {
        type: Array,
        required: true
    }
})

const latestOrdersHeaders = [
    { title: 'Company', key: 'prospect.name', sortable: false },
    { title: 'Product', key: 'product.name', sortable: false },
    { title: 'LTS', key: 'quantity', sortable: false },
    { title: 'PPL Cost', key: 'ppl_cost', sortable: false },
    { title: 'PPL Sell', key: 'ppl_sell', sortable: false },
    { title: 'Total', key: 'total', sortable: false },
    { title: 'Total Profit', key: 'total_profit', sortable: true },
    { title: 'Date', key: 'created_at', sortable: true },
    { title: 'Action', key: 'actions', sortable: false }
];
</script>

<template>
    <v-card-title class="bg-primary mb-5 d-flex justify-space-between align-center">
        <span>Orders</span>
        <v-tooltip text="Add Order">
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
        <v-data-table
            :headers="latestOrdersHeaders"
            :items="props.getUserOrders"
            items-per-page="5"
            class="elevation-3"
        >
            <template v-slot:item.ppl_cost="{ item }">
                £{{ item.ppl_cost.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 4 }) }}
            </template>
            <template v-slot:item.ppl_sell="{ item }">
                £{{ item.ppl_sell.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 4 }) }}
            </template>
            <template v-slot:item.total="{ item }">
                £{{ item.total.toLocaleString() }}
            </template>
            <template v-slot:item.total_profit="{ item }">
                £{{ item.total_profit.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 4 }) }}
            </template>
            <template v-slot:item.created_at="{ item }">
                {{ new Date(item.created_at).toLocaleString('en-GB') }}
            </template>
            <template v-slot:item.actions="{ item }">
                <v-tooltip text="Edit Order">
                    <template v-slot:activator="{ props }">
                        <Link :href="route('prospects.show', item.id)">
                            <v-icon color="orange" :="props">
                                mdi-pencil
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
                <span class="headline">New Order</span>
            </v-card-title>
            <v-card-text>
                <AddOrder
                    @close="dialog = false"
                    :getUserCustomers="getUserCustomers"
                    :fromUserPage="true"
                />
            </v-card-text>
        </v-card>
    </v-dialog>
</template>
