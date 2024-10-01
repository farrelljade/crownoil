<script setup>
import {ref} from "vue";
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    getUserTotalProfitThisMonth: {
        type: Number,
        required: true,
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
        required: true,
    },
    getUserProfitTarget: {
        type: Number,
        required: true,
    },
});

const showDialogs = ref({
    monthProfit: false,
    customerProfit: false,
    userTotalOrders: false,
});

const openDialog = (dialogName) => {
    showDialogs.value[dialogName] = true;
};

const tab = ref(0);

const currentMonth = new Date().toLocaleString('en-GB', { month: 'long' });
const lastMonth = new Date(new Date().getFullYear(), new Date().getMonth() - 1, 1).toLocaleString('en-GB', { month: 'long' });
const monthBeforeLast = new Date(new Date().getFullYear(), new Date().getMonth() - 2, 1).toLocaleString('en-GB', { month: 'long' });
const daysInTheMonthRemaining = new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0).getDate() - new Date().getDate();

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
        <v-col class="cursor-pointer" cols="12" md="3" @click="openDialog('monthProfit')">
            <v-sheet
                class="dashboardInfo"
                border
                color="deep-purple-lighten-1"
                rounded
            >
                <div class="top-row">
                    <div class="name">
                        Profit for {{ currentMonth }}
                    </div>

                    <div class="information">
                        <v-tooltip text="Total profit this month" location="left">
                            <template v-slot:activator="{ props }">
                                <v-icon color="white" v-bind="props">
                                    mdi-information-outline
                                </v-icon>
                            </template>
                        </v-tooltip>
                    </div>
                </div>

                <div class="center-row">
                    £{{ getUserTotalProfitThisMonth.toLocaleString() }}
                </div>

                <div class="bottom-row">
                    <div class="bottom-left">
<!--                        Target - £{{ getUserProfitTarget.toLocaleString() }}-->
                    </div>
                    <div class="bottom-right">
                        {{ (getUserTotalProfitThisMonth / getUserProfitTarget * 100).toFixed(2) }}%
                    </div>
                </div>
            </v-sheet>
        </v-col>

        <v-col class="cursor-pointer" cols="12" md="3" @click="openDialog('customerProfit')">
            <v-sheet
                class="dashboardInfo"
                :elevation="12"
                border
                color="deep-orange-lighten-1"
                rounded
            >
                <div class="top-row">
                    <div class="name">
                        Most Profit - {{ currentMonth }}
                    </div>

                    <div class="information">
                        <v-tooltip text="Customer with the highest profit this month" location="left">
                            <template v-slot:activator="{ props }">
                                <v-icon color="white" v-bind="props">
                                    mdi-information-outline
                                </v-icon>
                            </template>
                        </v-tooltip>
                    </div>
                </div>

                <div class="center-row">
                    {{ getCustomersThisMonthByProfit.length > 0 ? getCustomersThisMonthByProfit[0].prospect.name : 'No Orders' }}
                </div>

                <div class="bottom-row">
                    <div class="bottom-left">
                        Days remaining: {{ daysInTheMonthRemaining }}
                    </div>
                </div>
            </v-sheet>
        </v-col>

        <v-col cols="12" md="3" @click="openDialog('userTotalOrders')">
            <v-sheet
                class="dashboardInfo"
                :elevation="12"
                color="blue"
                rounded
            >
                <div class="top-row">
                    <div class="name">
                        Total Orders - {{ currentMonth }}
                    </div>

                    <div class="information">
                        <v-tooltip text="Total orders this month" location="left">
                            <template v-slot:activator="{ props }">
                                <v-icon color="white" v-bind="props">
                                    mdi-information-outline
                                </v-icon>
                            </template>
                        </v-tooltip>
                    </div>
                </div>

                <div class="center-row">
                    {{ getUserTotalOrdersThisMonth }}
                </div>

                <div class="bottom-row">
                    <div class="bottom-left">
                        {{ lastMonth }} - {{ getUserTotalOrdersLastMonth || 0 }}
                    </div>
                    <div class="bottom-right">
                        {{ monthBeforeLast }} - {{ getUserTotalOrdersMonthBeforeLast || 0 }}
                    </div>
                </div>
            </v-sheet>
        </v-col>
    </v-row>

    <v-dialog
        v-model="showDialogs.monthProfit"
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
                                :items="getUserOrdersThisMonth"
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
                                :items="getUserOrdersLastMonth"
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
                                :items="getUserOrdersMonthBeforeLast"
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
        v-model="showDialogs.customerProfit"
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
                                :items="getCustomersThisMonthByProfit"
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

                    <v-tabs-window-item value="lastMonthsHighestCustomer">
                        <v-row dense>
                            <v-data-table
                                :headers="customersByProfitHeaders"
                                :items="getCustomersLastMonthByProfit"
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
