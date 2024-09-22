<script setup>
import {ref, watch} from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import App from '@/App.vue';

const props = defineProps({
    users: {
        type: Array,
        required: true
    },
    existingTargets: {
        type: Object,
        default: () => ({})
    }
});

const targetFields = [
    { title: 'Calls Target', key: 'calls_target' },
    { title: 'Prospect Target', key: 'prospect_target' },
    { title: 'Profit Target', key: 'profit_target' },
    { title: 'Rejuve Target', key: 'rejuve_target' },
    { title: 'IHO Target', key: 'iho_target' },
    { title: 'Lubricant Target', key: 'lubricant_target' },
];

const targets = ref({});

// Initialize target data
props.users.forEach(user => {
    const userTargets = props.existingTargets[user.id] || {};
    targets.value[user.id] = {
        calls_target: userTargets.calls_target || 0,
        prospect_target: userTargets.prospect_target || 0,
        profit_target: userTargets.profit_target || 0,
        rejuve_target: userTargets.rejuve_target || 0,
        iho_target: userTargets.iho_target || 0,
        lubricant_target: userTargets.lubricant_target || 0,
    };
});

const form = useForm({
    targets: targets.value
});

const updateTargets = () => {
    const updatedTargets = {};

    Object.keys(form.targets).forEach(userId => {
        updatedTargets[userId] = {};
        const userTargets = form.targets[userId];
        const originalUserTargets = props.existingTargets[userId] || {};

        Object.keys(userTargets).forEach(key => {
            if (userTargets[key] !== originalUserTargets[key]) {
                // Only add modified targets
                updatedTargets[userId][key] = userTargets[key];
            }
        });

        // Remove empty target objects
        if (Object.keys(updatedTargets[userId]).length === 0) {
            delete updatedTargets[userId];
        }
    });

    // If there are any changes, submit the form
    if (Object.keys(updatedTargets).length > 0) {
        form.post('/user-targets', {
            preserveScroll: true,
            onSuccess: () => {
                console.log('Form successfully submitted');
            },
            onError: serverErrors => {
                console.log('Error:', serverErrors);
            }
        });
    } else {
        console.log('No changes detected');
    }
};


watch(targets, (newTargets) => {
    form.targets = newTargets;
}, { deep: true });

</script>

<template>
    <Head title="User Targets"/>
    <App>
        <v-container fluid>
            <v-card>
                <v-card-title class="bg-primary mb-5 d-flex justify-space-between align-center">
                    User Targets
                </v-card-title>
                <v-card-text>
                    <v-table>
                        <thead>
                        <tr>
                            <th>User Name</th>
                            <th v-for="field in targetFields" :key="field.key">{{ field.title }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="user in users" :key="user.id">
                            <td>{{ user.name }}</td>
                            <td v-for="field in targetFields" :key="field.key">
                                <v-text-field
                                    v-model="form.targets[user.id][field.key]"
                                    hide-details
                                    density="compact"
                                    outlined
                                    type="number"
                                />
                            </td>
                        </tr>
                        </tbody>
                    </v-table>
                    <v-btn color="primary" class="mt-4" @click="updateTargets">Save Targets</v-btn>
                </v-card-text>
            </v-card>
        </v-container>
    </App>
</template>
