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
    }
});
</script>

<template>
    <Head title="Prospects" />

    <App>
        <template v-slot:default>
            <div>
                <ProspectList :prospects="prospects" />
            </div>
        </template>
    </App>
</template>
