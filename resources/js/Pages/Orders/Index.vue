<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import App from '@/App.vue';
import AddOrder from '@/Pages/Orders/Components/AddOrder.vue';

const dialog = ref(false);

const props = defineProps({
    orders: {
        type: Array,
        required: true
    },
    filters: {
        type: Object,
        required: true
    },
    products: {
        type: Array,
        required: true
    },
    prospects: {
        type: Array,
        required: true
    }
});

const params = ref({
    product_id: null,
    prospect_id: null,
    name: null
});

const tableData = computed(() => {
    return props.orders.filter(order => {
        return (!params.value.product_id || order.product_id === params.value.product_id)
            && (!params.value.prospect_id || order.prospect_id === params.value.prospect_id)
            && (!params.value.name || order.name === params.value.name);
    });
});

const latestOrdersHeaders = [
    { title: 'Product', key: 'product.name', sortable: false },
    { title: 'Prospect', key: 'prospect.name', sortable: false },
    { title: 'Quantity', key: 'quantity', sortable: false },
    { title: 'PPL', key: 'ppl', sortable: false },
    { title: 'Total', key: 'total', sortable: false },
    { title: 'Action', key: 'actions', sortable: false }
];

</script>

<template>
    <Head title="Orders" />

    <App>
        <v-container fluid>
            <v-card class="mb-2 pa-3">
                <v-card-title class="bg-primary mb-5 d-flex justify-space-between align-center">
                    <span>Orders</span>
                    <v-tooltip text="New Order">
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
            </v-card>

            <v-card>
                <v-card-text>
                    <v-data-table
                        :headers="latestOrdersHeaders"
                        :items="tableData"
                        class="elevation-3"
                    >
                        <template v-slot:item.product.name="{ item }">
                            {{ item.product.name }}
                        </template>
                    </v-data-table>
                </v-card-text>
            </v-card>
        </v-container>

        <v-dialog v-model="dialog" max-width="900px">
            <v-card>
                <v-card-title class="bg-primary mb-5 d-flex justify-space-between align-center">
                    <span class="headline">New Order</span>
                </v-card-title>
                <v-card-text>
                    <AddOrder
                        @close="dialog = false"
                        :products="products"
                        :prospects="prospects"
                    />
                </v-card-text>
            </v-card>
        </v-dialog>
    </App>
</template>
