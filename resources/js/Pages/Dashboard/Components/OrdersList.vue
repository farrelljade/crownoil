<script setup>
import {computed, defineProps} from 'vue';
import AddOrder from "@/Pages/Orders/Components/AddOrder.vue";
import {ref} from "vue";
import axios from 'axios';

const props = defineProps({
    order: {
        type: Object,
        required: true
    },
    getUserOrders: {
        type: Array,
        required: true
    },
    getUserCustomers: {
        type: Array,
        required: true
    }
})

const showDialog = ref({
    addOrderDialog: false,
    showOrderDialog: false
});

const selectedOrder = ref(null);
const isLoadingOrder = ref(false);

const openOrderDialog = async (orderId) => {
    isLoadingOrder.value = true;
    try {
        const response = await axios.get(`/orders/${orderId}/details`);
        selectedOrder.value = response.data.order;
        showDialog.value.showOrderDialog = true;
    } catch (error) {
        console.error('Error fetching order details:', error);
    } finally {
        isLoadingOrder.value = false;
    }
};

const openDialog = (dialogName) => {
    showDialog.value[dialogName] = true;
};

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

const showOrderHeader = [
    { title: 'Product', key: 'product.name', sortable: false },
    { title: 'Quantity', key: 'quantity', sortable: false },
    { title: 'PPL Cost', key: 'ppl_cost', sortable: false },
    { title: 'PPL Sell', key: 'ppl_sell', sortable: false },
    { title: 'VAT', key: 'vat', sortable: false },
    { title: 'Nett Total', key: 'nett_total', sortable: false},
    { title: 'Total Cost', key: 'total', sortable: false },
    { title: 'PPL Profit', key: 'ppl_profit', sortable: false },
    { title: 'Total Profit', key: 'total_profit', sortable: false },
];

const orderData = computed(() => {
    console.log('Order Data:', orderData);
    return props.order ? [props.order] : [];
});
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
                    @click="openDialog('addOrderDialog')"
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
                <v-tooltip text="View order">
                    <template v-slot:activator="{ props }">
                        <v-btn @click="openOrderDialog(item.id)">
                            <v-icon color="orange" :="props">
                                mdi-pencil
                            </v-icon>
                        </v-btn>
                    </template>
                </v-tooltip>
            </template>
        </v-data-table>
    </v-card-text>

    <v-dialog v-model="showDialog.addOrderDialog" max-width="auto">
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

    <v-dialog v-model="showDialog.showOrderDialog" width="auto">
        <v-card>
            <v-card-title class="bg-primary mb-5 d-flex justify-space-between align-center">
                <span class="headline">Order Details</span>
            </v-card-title>
            <v-card-text style="max-height: 80vh;">
                <v-progress-linear
                    v-if="isLoadingOrder"
                    indeterminate
                    color="primary"
                ></v-progress-linear>

                <v-data-table
                    v-else
                    :headers="showOrderHeader"
                    :items="[selectedOrder]"
                    hide-default-footer
                >
                    <template v-slot:item.quantity="{ item }">
                        {{ item.quantity.toLocaleString() }}
                    </template>
                    <template v-slot:item.ppl_cost="{ item }">
                        £{{ item.ppl_cost.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 4 }) }}
                    </template>
                    <template v-slot:item.ppl_sell="{ item }">
                        £{{ item.ppl_sell.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 4 }) }}
                    </template>
                    <template v-slot:item.vat="{ item }">
                        £{{ item.vat.toLocaleString() }}
                    </template>
                    <template v-slot:item.nett_total="{ item }">
                        £{{ item.nett_total.toLocaleString() }}
                    </template>
                    <template v-slot:item.total="{ item }">
                        £{{ item.total.toLocaleString() }}
                    </template>
                    <template v-slot:item.ppl_profit="{ item }">
                        £{{ item.ppl_profit.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 4 }) }}
                    </template>
                    <template v-slot:item.total_profit="{ item }">
                        <b>£{{ item.total_profit.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 4 }) }}</b>
                    </template>
                </v-data-table>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>
