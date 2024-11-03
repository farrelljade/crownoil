<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import App from '@/App.vue';
import AddOrder from '@/Pages/Orders/Components/AddOrder.vue';
import CustomVAutocomplete from "@/Components/CustomVAutocomplete.vue";

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
    },
    users: {
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
    { title: 'Order Number', key: 'id', sortable: false },
    { title: 'Company', key: 'prospect.name', sortable: false },
    { title: 'Product', key: 'product.name', sortable: false },
    { title: 'LTS', key: 'quantity', sortable: false },
    { title: 'PPL', key: 'ppl_sell', sortable: false },
    { title: 'Total', key: 'total', sortable: false },
    { title: 'Assigned User', key: 'user.name', sortable: false },
    { title: 'Created At', key: 'created_at', sortable: true },
    { title: 'Action', key: 'actions', sortable: false }
];
</script>

<template>
    <Head title="Orders" />

    <App>
        <v-container fluid>
            <v-card class="mb-2 pa-3">
                <v-card-title class="bg-primary mb-5 d-flex justify-space-between align-center">
                    Orders
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

                <v-card-text>
                    <v-row>
                        <v-col cols="12" md="3">
                            <CustomVAutocomplete
                                v-model="params.product_id"
                                :items="products"
                                item-value="id"
                                item-title="name"
                                label="Product"
                                clearable
                            />
                        </v-col>
                        <v-col cols="12" md="3">
                            <CustomVAutocomplete
                                v-model="params.prospect_id"
                                :items="prospects"
                                item-value="id"
                                item-title="name"
                                label="Company"
                                clearable
                            />
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>

            <v-card>
                <v-card-text>
                    <v-data-table
                        :headers="latestOrdersHeaders"
                        :items="tableData"
                        class="elevation-3"
                    >
                        <template v-slot:item.user.name="{ item }">
                            {{ item.user.name }}
                        </template>
                        <template v-slot:item.product.name="{ item }">
                            {{ item.product.name }}
                        </template>
                        <template v-slot:item.quantity="{ item }">
                            {{ item.quantity }}
                        </template>
                        <template v-slot:item.prospect.name="{ item }">
                            {{ item.prospect.name }}
                        </template>
                        <template v-slot:item.ppl_sell="{ item }">
                            £{{ item.ppl_sell.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 4 }) }}
                        </template>
                        <template v-slot:item.total="{ item }">
                            £{{ item.total.toLocaleString() }}
                        </template>
                        <template v-slot:item.created_at="{ item }">
                            {{ new Date(item.created_at).toLocaleString('en-GB') }}
                        </template>
                        <template v-slot:item.actions="{ item }">
                            <v-tooltip text="Go To Profile" bottom>
                                <template v-slot:activator="{ props }">
                                    <Link :href="route('prospects.show', item.prospect.id)">
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

        <v-dialog v-model="dialog">
            <v-card>
                <v-card-title class="bg-primary mb-5 d-flex justify-space-between align-center">
                    <span class="headline">New Order</span>
                </v-card-title>
                <v-card-text>
                    <AddOrder
                        @close="dialog = false"
                        :products="products"
                        :prospects="prospects"
                        :users="users"
                    />
                </v-card-text>
            </v-card>
        </v-dialog>
    </App>
</template>
