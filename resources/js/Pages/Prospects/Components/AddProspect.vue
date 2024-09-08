<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import CustomVTextField from "@/Components/CustomVTextField.vue";
import CustomVAutocomplete from "@/Components/CustomVAutocomplete.vue";

const dialog = ref(false);

const form = useForm({
    name: '',
    lead_source_id: null,
    user_id: null,
    contact_name: '',
    line_1: '',
    line_2: '',
    line_3: '',
    city: '',
    county: '',
    postcode: '',
    number: '',
    email: '',
});

const props = defineProps({
    leadSource: {
        type: Array,
        required: true,
    },
    users: {
        type: Array,
        required: true,
    },
});

const emit = defineEmits(['close']);

const submitForm = () => {
    form.post('/prospects', {
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
                    <CustomVTextField
                        v-model="form.name"
                        label="Company Name"
                        required
                    />
                </v-col>
                <v-col cols="12" md="4">
                    <CustomVAutocomplete
                        v-model="form.lead_source_id"
                        :items="leadSource"
                        item-value="id"
                        item-title="name"
                        label="Lead Source"
                        required
                    />
                </v-col>
                <v-col cols="12" md="4">
                    <CustomVAutocomplete
                        v-model="form.user_id"
                        :items="users"
                        item-value="id"
                        item-title="name"
                        label="Assigned User"
                        required
                    />
                </v-col>
                <v-col cols="12" md="4">
                    <CustomVTextField
                        v-model="form.contact_name"
                        label="Contact Name"
                        required
                    />
                </v-col>
                <v-col cols="12" md="4">
                    <CustomVTextField
                        v-model="form.line_1"
                        label="Line 1"
                        required
                    />
                </v-col>
                <v-col cols="12" md="4">
                    <CustomVTextField
                        v-model="form.line_2"
                        label="Line 2"
                    />
                </v-col>
                <v-col cols="12" md="4">
                    <CustomVTextField
                        v-model="form.line_3"
                        label="Line 3"
                    />
                </v-col>
                <v-col cols="12" md="4">
                    <CustomVTextField
                        v-model="form.city"
                        label="City"
                        required
                    />
                </v-col>
                <v-col cols="12" md="4">
                    <CustomVTextField
                        v-model="form.county"
                        label="County"
                    />
                </v-col>
                <v-col cols="12" md="4">
                    <CustomVTextField
                        v-model="form.postcode"
                        label="Postcode"
                        required
                    />
                </v-col>
                <v-col cols="12" md="4">
                    <CustomVTextField
                        v-model="form.number"
                        label="Contact Number"
                        required
                    />
                </v-col>
                <v-col cols="12" md="4">
                    <CustomVTextField
                        v-model="form.email"
                        type="email"
                        label="Email Address"
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
