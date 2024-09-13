<script setup>
</script>

<template>
    <v-row>
        <v-col class="cursor-pointer" cols="12" md="3">
            <v-sheet
                class="dashboardInfo"
                :elevation="12"
                :height="100"
                border
                color="deep-purple-lighten-1"
                rounded
            >
                <!-- Tooltip in the top right -->
                <v-col class="information top-right">
                    <v-tooltip text="Total profit" location="bottom">
                        <template v-slot:activator="{ props }">
                            <v-icon color="white" v-bind="props">
                                mdi-information-outline
                            </v-icon>
                        </template>
                    </v-tooltip>
                </v-col>

                <!-- "Profit" in the middle -->
                <v-col class="name centered-text">
                    Profit
                </v-col>

                <!-- Profit values in the bottom left and right -->
                <v-col class="profitValueSmallLeft bottom-left">
                    £3000
                </v-col>
                <v-col class="profitValueSmallRight bottom-right">
                    £5000
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
