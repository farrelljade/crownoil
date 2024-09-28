<script setup>
import {ref, watch} from 'vue';
import {Head, useForm} from '@inertiajs/vue3';
import App from '@/App.vue';

const props = defineProps({
    users: {
        type: Array,
        required: true
    },
    userTargets: {
        type: Object,
        default: () => ({})
    },
    targets: { // Prop for available targets
        type: Array,
        required: true
    }
});

const targets = ref({});

// Initialize target data
props.users.forEach(user => {
    targets.value[user.id] = {};

    // Match targets based on the `target_id`
    props.targets.forEach(target => {
        const userTarget = props.userTargets[user.id]?.find(t => t.target_id === target.id) || {};
        targets.value[user.id][target.id] = userTarget.value || 0;
    });
});

const form = useForm({
    targets: targets.value
});

const updateTargets = () => {
    const updatedTargets = [];

    Object.keys(form.targets).forEach(userId => {
        const userTargets = form.targets[userId];
        const originalUserTargets = props.userTargets[userId] || [];

        Object.keys(userTargets).forEach(targetId => {
            const newValue = userTargets[targetId];
            const original = originalUserTargets.find(t => t.target_id === parseInt(targetId)) || {};

            if (newValue !== original.value) {
                updatedTargets.push({
                    user_id: parseInt(userId),
                    target_id: parseInt(targetId),
                    value: newValue
                });
            }
        });
    });

    if (updatedTargets.length > 0) {
        form.post('/user-targets', {
            preserveScroll: true,
            data: {targets: updatedTargets},
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
}, {deep: true});

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
                            <th v-for="target in targets" :key="target.id">{{ target.name }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="user in users" :key="user.id">
                            <td>{{ user.name }}</td>
                            <td v-for="target in targets" :key="target.id">
                                <v-text-field
                                    v-model="form.targets[user.id][target.id]"
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
