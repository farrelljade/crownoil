<script setup>
import { Head } from '@inertiajs/vue3';
import {defineAsyncComponent, ref} from 'vue';
import App from '@/App.vue';
import SheetInformation from "@/Pages/Dashboard/Components/SheetInformation.vue";

const tab = ref(0);

const ProspectList = defineAsyncComponent(
    () => import('@/Pages/Dashboard/Components/ProspectList.vue')
);

const CustomerList = defineAsyncComponent(
    () => import('@/Pages/Dashboard/Components/CustomerList.vue')
)

const OrdersList = defineAsyncComponent(
    () => import('@/Pages/Dashboard/Components/OrdersList.vue')
);

const props = defineProps({
    prospects: {
        type: Array,
        required: true,
    },
    order: {
        type: Object,
        required: true
    },
    getUserCustomerList: {
        type: Array,
        required: true
    },
    users: {
        type: Array,
        required: true,
    },
    leadSource: {
        type: Array,
        required: true,
    },
    getUserOrders: {
        type: Array,
        required: true,
    },
    userTotalProfit: {
        type: Number,
        required: true,
    },
    getUserTotalProfitThisMonth: {
        type: Number,
        required: true,
    },
    getUserTotalProfitLastMonth: {
        type: Number,
        required: true
    },
    getUserTotalProfitMonthBeforeLast: {
        type: Number,
        required: true
    },
    getUserOrdersThisMonth: {
        type: Array,
        required: true,
    },
    getUserOrdersLastMonth: {
        type: Array,
        required: true,
    },
    getUserOrdersMonthBeforeLast: {
        type: Array,
        required: true,
    },
    getCustomersThisMonthByProfit: {
        type: Array,
        required: true,
    },
    getCustomersLastMonthByProfit: {
        type: Array,
        required: true,
    },
    getUserTotalOrdersThisMonth: {
        type: Number,
        required: true,
    },
    getUserTotalOrdersLastMonth: {
        type: Number,
        required: true,
    },
    getUserTotalOrdersMonthBeforeLast: {
        type: Number,
        required: true
    },
    getUserCustomers: {
        type: Array,
        required: true,
    },
    getUserProfitTarget: {
        type: Number,
        required: true,
    },
});
</script>

<template>
    <Head title="User Page" />

    <App>
        <v-container fluid>
            <v-row>
                <v-col cols="12">
                    <v-card>
                        <template v-slot:default>
                            <div>
                                <SheetInformation
                                    :getUserTotalProfitThisMonth="getUserTotalProfitThisMonth"
                                    :getUserTotalProfitLastMonth="getUserTotalProfitLastMonth"
                                    :getUserTotalProfitMonthBeforeLast="getUserTotalProfitMonthBeforeLast"
                                    :getUserOrdersThisMonth="getUserOrdersThisMonth"
                                    :getUserOrdersLastMonth="getUserOrdersLastMonth"
                                    :getUserOrdersMonthBeforeLast="getUserOrdersMonthBeforeLast"
                                    :getCustomersThisMonthByProfit="getCustomersThisMonthByProfit"
                                    :getCustomersLastMonthByProfit="getCustomersLastMonthByProfit"
                                    :getUserTotalOrdersThisMonth="getUserTotalOrdersThisMonth"
                                    :getUserTotalOrdersLastMonth="getUserTotalOrdersLastMonth"
                                    :getUserTotalOrdersMonthBeforeLast="getUserTotalOrdersMonthBeforeLast"
                                    :getUserProfitTarget="getUserProfitTarget"
                                />
                            </div>
                        </template>
                    </v-card>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="5">
                    <v-card>
                        <v-tabs
                            v-model="tab"
                            bg-color="primary"
                        >
                            <v-tab value="prospectList">Prospect List</v-tab>
                            <v-tab value="customerList">Customer List</v-tab>
                        </v-tabs>
                        <v-card-text style="overflow: auto; max-height: 80vh;">
                            <v-tabs-window v-model="tab">
                                <v-tabs-window-item value="prospectList">
                                    <template v-slot:default>
                                        <div>
                                            <ProspectList
                                                :prospects="prospects"
                                                :users="users"
                                                :leadSource="leadSource"
                                            />
                                        </div>
                                    </template>
                                </v-tabs-window-item>

                                <v-tabs-window-item value="customerList">
                                    <template v-slot:default>
                                        <div>
                                            <CustomerList
                                                :getUserCustomerList="getUserCustomerList"
                                            />
                                        </div>
                                    </template>
                                </v-tabs-window-item>
                            </v-tabs-window>
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-col cols="12" md="7">
                    <v-card>
                        <template v-slot:default>
                            <div>
                                <OrdersList
                                    :getUserOrders="getUserOrders"
                                    :getUserCustomers="getUserCustomers"
                                    :order="order"
                                />
                            </div>
                        </template>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </App>
</template>
