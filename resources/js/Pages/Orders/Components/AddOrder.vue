<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const dialog = ref(false);

const form = useForm({
    prospect_id: null,
    product_id: null,
    quantity: null,
    ppl: null,
    total: null,
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
});

const simpleProducts = [
    { id: 1, name: 'Product A' },
    { id: 2, name: 'Product B' }
];

const simpleProspects = [
    { id: 1, name: 'Prospect A' },
    { id: 2, name: 'Prospect B' }
];

console.log('Simple Products:', simpleProducts);
console.log('Simple Prospects:', simpleProspects);


console.log('Products:', props.products);
console.log('Prospects:', props.prospects);

const emit = defineEmits(['close']);

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
                <v-col cols="12" md="4">
                    <v-autocomplete
                        v-model="form.prospect_id"
                        :items="prospects"
                        item-value="id"
                        item-title="name"
                        label="Prospect"
                        required
                    />
                </v-col>
                <v-col cols="12" md="4">
                    <v-autocomplete
                        v-model="form.product_id"
                        :items="products"
                        item-value="id"
                        item-title="name"
                        label="Product"
                        required
                    />
                </v-col>
                <v-col cols="12" md="4">
                    <v-text-field
                        v-model="form.quantity"
                        label="Quantity"
                        required
                    />
                </v-col>
                <v-col cols="12" md="4">
                    <v-text-field
                        v-model="form.ppl"
                        label="PPL"
                        required
                    />
                </v-col>
                <v-col cols="12" md="4">
                    <v-text-field
                        v-model="form.total"
                        label="Total"
                        required
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
