<script setup>
import {computed, onMounted, ref, watch} from 'vue';
import { useForm } from '@inertiajs/vue3';

const dialog = ref(false);

const form = useForm({
    user_id: null,
    prospect_id: null,
    product_id: null,
    quantity: null,
    ppl_cost: null,
    ppl_sell: null,
    nett_total: null,
    vat: null,
    total: null,
    ppl_profit: null,
    total_profit: null,
});

const props = defineProps({
    products: {
        type: Array,
        required: true,
    },
    prospects: {
        type: Array,
        required: true,
    },
    users: {
        type: Array,
        required: true,
    },
    prospectName: {
        type: Object,
        default: null,
    },
    assignedUserName: {
        type: Object,
        default: null,
    },
    customerProducts: {
        type: Array,
        default: null,
    },
});

const emit = defineEmits(['close']);

const pricing = {
    'Derv': { threshold: 10000, low: 1.10, high: 1.05 },
    'IHO': { threshold: 10000, low: 0.70, high: 0.65 },
    'Kerosene': { threshold: 10000, low: 0.68, high: 0.63 },
    'Gas Oil': { threshold: 10000, low: 0.85, high: 0.80 },
};

const pplCost = computed(() => {
    const productList = props.customerProducts && props.customerProducts.length > 0
        ? props.customerProducts
        : props.products;

    if (!form.product_id || !form.quantity) return null;

    const selectedProduct = productList.find(
        (product) => product.id === form.product_id
    );
    if (!selectedProduct) return null;

    const productPricing = pricing[selectedProduct.name];
    if (!productPricing) return null;

    return form.quantity < productPricing.threshold
        ? productPricing.low
        : productPricing.high;
});

const nettTotal = computed(() => {
    if (!form.quantity || !form.ppl_sell) return null;
    return (form.quantity * form.ppl_sell).toFixed(2);
});

const vat = computed(() => {
    if (!form.quantity || !form.ppl_sell) return null;
    const nettCost = form.quantity * form.ppl_sell;
    return (nettCost * 0.20).toFixed(2);
});

const totalCost = computed(() => {
    if (!form.quantity || !form.ppl_sell) return null;
    const nettCost = form.quantity * form.ppl_sell;
    return (nettCost + parseFloat(vat.value)).toFixed(2);
});

const pplProfit = computed(() => {
    if (!form.quantity || !form.ppl_sell) return null;
    return (form.ppl_sell - form.ppl_cost).toFixed(2);
});

const totalProfit = computed(() => {
    if (!form.quantity || !form.ppl_sell) return null;
    return (form.quantity * form.ppl_profit).toFixed(2);
});

watch(pplCost, (newPplCost) => {
    form.ppl_cost = newPplCost;
});

watch(vat, (newVat) => {
    form.vat = newVat;
});

watch(nettTotal, (newNettTotal) => {
    form.nett_total = newNettTotal;
});

watch(totalCost, (newTotalCost) => {
    form.total = newTotalCost;
});

watch(pplProfit, (newPplProfit) => {
    form.ppl_profit = newPplProfit;
});

watch(totalProfit, (newTotalProfit) => {
    form.total_profit = newTotalProfit;
});

onMounted(() => {
    if (props.assignedUserName) {
        form.user_id = props.assignedUserName.id;
    } else {
        watch(() => form.prospect_id, (newProspectId) => {
            const selectedProspect = props.prospects.find(prospect => prospect.id === newProspectId);
            if (selectedProspect && selectedProspect.user_id) {
                form.user_id = selectedProspect.user_id;
            }
        });
    }

    if (props.prospectName) {
        form.prospect_id = props.prospectName.id;
    }
});

const submitForm = () => {
    form.post('/orders', {
        onSuccess: () => {
            form.reset();
            emit('close');
        },
    });
};
</script>

<template>
    <v-form @submit.prevent="submitForm">
        <v-container fluid>
            <v-row>
                <v-col cols="12" md="3">
                    <v-autocomplete
                        v-model="form.prospect_id"
                        :items="prospects"
                        item-value="id"
                        item-title="name"
                        label="Prospect"
                        required
                    />
                </v-col>
                <v-col cols="12" md="3">
                    <v-autocomplete
                        v-model="form.user_id"
                        :items="users"
                        item-value="id"
                        item-title="name"
                        label="Assigned User"
                        required
                    />
                </v-col>
                <v-col cols="12" md="3">
                    <v-autocomplete
                        v-model="form.product_id"
                        :items="customerProducts || products"
                        item-value="id"
                        item-title="name"
                        label="Product"
                        required
                    />
                </v-col>
                <v-col cols="12" md="3">
                    <v-text-field
                        v-model="form.quantity"
                        label="Quantity"
                        required
                    />
                </v-col>
                <v-col cols="12" md="3">
                    <v-text-field
                        v-model="form.ppl_cost"
                        :value="pplCost"
                        label="PPL Cost"
                        readonly
                    />
                </v-col>
                <v-col cols="12" md="3">
                    <v-text-field
                        v-model="form.ppl_sell"
                        label="PPL Sell"
                        required
                    />
                </v-col>
                <v-col cols="12" md="3">
                    <v-text-field
                        v-model="form.vat"
                        :value="vat"
                        label="VAT"
                        readonly
                    />
                </v-col>
                <v-col cols="12" md="3">
                    <v-text-field
                        v-model="form.nett_total"
                        :value="nettTotal"
                        label="Nett Total"
                        readonly
                    />
                </v-col>
                <v-col cols="12" md="3">
                    <v-text-field
                        v-model="form.total"
                        :value="totalCost"
                        label="Total"
                        readonly
                    />
                </v-col>
                <v-col cols="12" md="3">
                    <v-text-field
                        v-model="form.ppl_profit"
                        :value="pplProfit"
                        label="PPL Profit"
                        readonly
                    />
                </v-col>
                <v-col cols="12" md="3">
                    <v-text-field
                        v-model="form.total_profit"
                        :value="totalProfit"
                        label="Total Profit"
                        readonly
                    />
                </v-col>
                <v-col cols="12" md="4">
                    <v-btn
                        class="mr-4"
                        color="error"
                        @click="dialog = false"
                    >
                        Cancel
                    </v-btn>

                    <v-btn
                        type="submit"
                        color="primary"
                    >
                        Submit
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
    </v-form>
</template>
