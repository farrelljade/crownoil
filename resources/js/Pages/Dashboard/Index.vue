<script setup>
import { Head } from '@inertiajs/vue3';
import { defineAsyncComponent } from 'vue';
import App from '@/App.vue';

const ProspectList = defineAsyncComponent(
    () => import('@/Pages/Dashboard/Components/ProspectList.vue')
);

const OrdersList = defineAsyncComponent(
    () => import('@/Pages/Dashboard/Components/OrdersList.vue')
);

const props = defineProps({
    prospects: {
        type: Array,
        required: true,
    },
    users: {
        type: Array,
        required: true,
    },
    leadSource: {
        type: Array,
        required: true,
    },
    userOrders: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <Head title="Prospects" />

    <App>
        <v-container fluid>
            <v-row>
                <v-col cols="12" md="6">
                    <v-card class="mb-2 pa-3">
                        <template v-slot:default>
                            <div>
                                <ProspectList
                                    :prospects="prospects"
                                    :users="users"
                                    :leadSource="leadSource"
                                />
                            </div>
                        </template>
                    </v-card>
                </v-col>
                <v-col cols="12" md="6">
                    <v-card class="mb-2 pa-3">
                        <template v-slot:default>
                            <div>
                                <OrdersList
                                    :userOrders="userOrders"
                                />
                            </div>
                        </template>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </App>
</template>
