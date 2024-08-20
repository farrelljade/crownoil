<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const dialog = ref(false);
const form = useForm({
    name: '',
    lead_source_id: null,
    user_id: null,
    line_1: '',
    line_2: '',
    city: '',
    county: '',
    postcode: '',
    number: '',
    email: '',
    // Add other necessary fields
});

// Function to submit the form
function submitForm() {
    form.post(route('prospects.store'), {
        onSuccess: () => dialog.value = false
    });
}
</script>

<template>
    <Head title="Prospects" />

    <AuthenticatedLayout>
        <!-- Modal for adding a new prospect -->
        <v-dialog v-model="dialog" max-width="600px">
            <v-card>
                <v-card-title>
                    Add New Prospect
                </v-card-title>

                <v-card-text>
                    <v-form @submit.prevent="submitForm">
                        <v-text-field
                            v-model="form.name"
                            label="Company Name"
                            required
                        />
                        <v-select
                            v-model="form.user_id"
                            :items="users"
                            label="Assigned User"
                            item-value="id"
                            item-title="name"
                            required
                        />
                        <v-select
                            v-model="form.lead_source_id"
                            :items="leadSource"
                            label="Lead Source"
                            item-value="id"
                            item-title="name"
                            required
                        />
                        <v-text-field
                            v-model="form.line_1"
                            label="Address Line 1"
                            required
                        />
                        <v-text-field
                            v-model="form.line_2"
                            label="Address Line 2"
                        />
                        <v-text-field
                            v-model="form.city"
                            label="City"
                            required
                        />
                        <v-text-field
                            v-model="form.postcode"
                            label="Postcode"
                            required
                        />
                        <!-- Add other fields as necessary -->

                        <v-card-actions>
                            <v-btn color="primary" @click="submitForm">Save</v-btn>
                            <!-- <v-btn text @click="dialog.value = false">Cancel</v-btn> -->
                        </v-card-actions>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-dialog>
    </AuthenticatedLayout>
</template>