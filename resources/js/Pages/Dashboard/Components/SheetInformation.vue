<script setup>

const props = defineProps({
    userTotalProfit: {
        type: Number,
        required: true,
    },
});

const currentMonth = new Date().toLocaleString('en-GB', { month: 'long' });
const daysInTheMonthRemaining = new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0).getDate() - new Date().getDate();
</script>

<template>
    <v-row>
        <v-col class="cursor-pointer" cols="12" md="3">
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
                    £{{ userTotalProfit.toLocaleString() }}
                </v-col>

                <v-col class="profitValueSmallLeft bottom-left">
                    Target - £3000
                </v-col>
                <v-col class="profitValueSmallRight bottom-right">
                    Days remaining: {{ daysInTheMonthRemaining }}
                </v-col>
            </v-sheet>
        </v-col>

        <v-col class="cursor-pointer" cols="12" md="3">
            <v-sheet
                class="dashboardInfo"
                :elevation="12"
                :height="100"
                border
                color="deep-orange-lighten-1"
                rounded
            >
            </v-sheet>
        </v-col>
    </v-row>
</template>
