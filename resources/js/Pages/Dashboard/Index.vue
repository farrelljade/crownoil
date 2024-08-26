<script setup>
import { Head } from '@inertiajs/vue3';
import { defineAsyncComponent } from 'vue';
import App from '@/App.vue';

const ProspectList = defineAsyncComponent(
    () => import('@/Pages/Dashboard/Components/ProspectList.vue')
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
});
</script>

<template>
    <Head title="Prospects" />

    <App>
        <template v-slot:default>
            <div>
                <ProspectList :prospects="prospects" :users="users" :leadSource="leadSource" />
            </div>
        </template>
    </App>
</template>
