<script setup>
import {ref} from "vue";
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    userTotalProfitThisMonth: {
        type: Number,
        required: true,
    },
    userOrdersThisMonth: {
        type: Array,
        required: true,
    },
    userOrdersLastMonth: {
        type: Array,
        required: true,
    },
    userOrdersMonthBeforeLast: {
        type: Array,
        required: true,
    },
    customersThisMonthByProfit: {
        type: Array,
        required: true,
    },
});

const showMonthProfitDialog = ref(false);
const showCustomerProfitDialog = ref(false);
const tab = ref(0);

const currentMonth = new Date().toLocaleString('en-GB', { month: 'long' });
const lastMonth = new Date(new Date().getFullYear(), new Date().getMonth() - 1, 1).toLocaleString('en-GB', { month: 'long' });
const monthBeforeLast = new Date(new Date().getFullYear(), new Date().getMonth() - 2, 1).toLocaleString('en-GB', { month: 'long' });
const daysInTheMonthRemaining = new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0).getDate() - new Date().getDate();

const openMonthProfitDialog = () => {
    showMonthProfitDialog.value = true;
};

const openCustomerProfitDialog = () => {
    showCustomerProfitDialog.value = true;
};

const monthProfitHeaders = [
    { title: 'Company', key: 'prospect.name', sortable: true },
    { title: 'Product', key: 'product.name', sortable: true },
    { title: 'LTS', key: 'quantity', sortable: true },
    { title: 'PPL', key: 'ppl_sell', sortable: true },
    { title: 'Total', key: 'total', sortable: true },
    { title: 'Date', key: 'created_at', sortable: true },
    { title: 'Action', key: 'actions', sortable: false }
];

const customersByProfitHeaders = [
    { title: 'Company', key: 'prospect.name', sortable: true },
    { title: 'Total Orders', key: 'total_orders', sortable: true },
    { title: 'Total Profit', key: 'total_profit', sortable: true },
    { title: 'Action', key: 'actions', sortable: false }
];

</script>

<template>
    <v-row>
        <v-col class="cursor-pointer" cols="12" md="3" @click="openMonthProfitDialog">
            <v-sheet
                class="dashboardInfo"
                :height="100"
                border
                color="deep-purple-lighten-1"
                rounded
            >
                <v-col class="name top-left">
                    Profit for {{ currentMonth }}
                </v-col>

                <v-col class="information top-right">
                    <v-tooltip text="Total profit this month" location="left">
                        <template v-slot:activator="{ props }">
                            <v-icon color="white" v-bind="props">
                                mdi-information-outline
                            </v-icon>
                        </template>
                    </v-tooltip>
                </v-col>

                <v-col class="actualProfit centered-text">
                    £{{ userTotalProfitThisMonth.toLocaleString() }}
                </v-col>

                <v-col class="profitValueSmallLeft bottom-left">
                    Target - £3000
                </v-col>
                <v-col class="profitValueSmallRight bottom-right">
                    Days remaining: {{ daysInTheMonthRemaining }}
                </v-col>
            </v-sheet>
        </v-col>

        <v-col class="cursor-pointer" cols="12" md="3" @click="openCustomerProfitDialog">
            <v-sheet
                class="dashboardInfo"
                :elevation="12"
                :height="100"
                border
                color="deep-orange-lighten-1"
                rounded
            >
                <v-col class="name top-left">
                    Most Profit - {{ currentMonth }}
                </v-col>

                <v-col class="information top-right">
                    <v-tooltip text="Customer with the highest profit this month" location="left">
                        <template v-slot:activator="{ props }">
                            <v-icon color="white" v-bind="props">
                                mdi-information-outline
                            </v-icon>
                        </template>
                    </v-tooltip>
                </v-col>

                <v-col class="actualProfit centered-text">
                    {{ customersThisMonthByProfit[0].prospect.name }}
                </v-col>
            </v-sheet>
        </v-col>
    </v-row>

    <v-dialog
        v-model="showMonthProfitDialog"
        width="auto"
    >
        <v-card>
            <v-tabs
                v-model="tab"
                bg-color="primary"
                >
                <v-tab value="thisMonthsProfit">{{ currentMonth }}</v-tab>
                <v-tab value="lastMonthsProfit">{{ lastMonth }}</v-tab>
                <v-tab value="monthBeforeLastProfit">{{ monthBeforeLast }}</v-tab>
            </v-tabs>
            <v-card-text style="overflow: auto; max-height: 80vh;">
                <v-tabs-window v-model="tab">
                    <v-tabs-window-item value="thisMonthsProfit">
                        <v-row dense>
                            <v-data-table
                                :headers="monthProfitHeaders"
                                :items="userOrdersThisMonth"
                            >
                                <template v-slot:item.ppl_sell="{ item }">
                                    £{{ item.ppl_sell.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 4 }) }}
                                </template>
                                <template v-slot:item.total="{ item }">
                                    £{{ item.total.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }) }}
                                </template>
                                <template v-slot:item.created_at="{ item }">
                                    {{ new Date(item.created_at).toLocaleString('en-GB') }}
                                </template>
                                <template v-slot:item.actions="{ item }">
                                    <v-tooltip text="Go To Order" left>
                                        <template v-slot:activator="{ props }">
                                            <Link :href="route('orders.show', item.id)">
                                                <v-icon color="green" v-bind="props">
                                                    mdi-location-enter
                                                </v-icon>
                                            </Link>
                                        </template>
                                    </v-tooltip>
                                </template>
                            </v-data-table>
                        </v-row>
                    </v-tabs-window-item>

                    <v-tabs-window-item value="lastMonthsProfit">
                        <v-row dense>
                            <v-data-table
                                :headers="monthProfitHeaders"
                                :items="userOrdersLastMonth"
                            >
                                <template v-slot:item.ppl_sell="{ item }">
                                    £{{ item.ppl_sell.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 4 }) }}
                                </template>
                                <template v-slot:item.total="{ item }">
                                    £{{ item.total.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }) }}
                                </template>
                                <template v-slot:item.created_at="{ item }">
                                    {{ new Date(item.created_at).toLocaleString('en-GB') }}
                                </template>
                                <template v-slot:item.actions="{ item }">
                                    <v-tooltip text="Go To Order" left>
                                        <template v-slot:activator="{ props }">
                                            <Link :href="route('orders.show', item.id)">
                                                <v-icon color="green" v-bind="props">
                                                    mdi-location-enter
                                                </v-icon>
                                            </Link>
                                        </template>
                                    </v-tooltip>
                                </template>
                            </v-data-table>
                        </v-row>
                    </v-tabs-window-item>

                    <v-tabs-window-item value="monthBeforeLastProfit">
                        <v-row dense>
                            <v-data-table
                                :headers="monthProfitHeaders"
                                :items="userOrdersMonthBeforeLast"
                            >
                                <template v-slot:item.ppl_sell="{ item }">
                                    £{{ item.ppl_sell.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 4 }) }}
                                </template>
                                <template v-slot:item.total="{ item }">
                                    £{{ item.total.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }) }}
                                </template>
                                <template v-slot:item.created_at="{ item }">
                                    {{ new Date(item.created_at).toLocaleString('en-GB') }}
                                </template>
                                <template v-slot:item.actions="{ item }">
                                    <v-tooltip text="Go To Order" left>
                                        <template v-slot:activator="{ props }">
                                            <Link :href="route('orders.show', item.id)">
                                                <v-icon color="green" v-bind="props">
                                                    mdi-location-enter
                                                </v-icon>
                                            </Link>
                                        </template>
                                    </v-tooltip>
                                </template>
                            </v-data-table>
                        </v-row>
                    </v-tabs-window-item>
                </v-tabs-window>
            </v-card-text>
        </v-card>
    </v-dialog>

    <v-dialog
        v-model="showCustomerProfitDialog"
        width="auto"
    >
        <v-card>
            <v-tabs
                v-model="tab"
                bg-color="primary"
                >
                <v-tab value="thisMonthsHighestCustomer">{{ currentMonth }}</v-tab>
                <v-tab value="lastMonthsHighestCustomer">{{ lastMonth }}</v-tab>
                <v-tab value="monthBeforeLastHighestCustomer">{{ monthBeforeLast }}</v-tab>
            </v-tabs>
            <v-card-text style="overflow: auto; max-height: 80vh;">
                <v-tabs-window v-model="tab">
                    <v-tabs-window-item value="thisMonthsHighestCustomer">
                        <v-row dense>
                            <v-data-table
                                :headers="customersByProfitHeaders"
                                :items="customersThisMonthByProfit"
                            >
                                <template v-slot:item.total_profit="{ item }">
                                    £{{ item.total_profit.toLocaleString() }}
                                </template>
                                <template v-slot:item.actions="{ item }">
                                    <v-tooltip text="Go To Profile" left>
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
                        </v-row>
                    </v-tabs-window-item>
                </v-tabs-window>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>
