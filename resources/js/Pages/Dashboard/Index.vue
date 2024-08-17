<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { defineAsyncComponent } from 'vue';

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

    <AuthenticatedLayout>
        <!-- Load the ProspectList component -->
        <div class="mb-6">
            <ProspectList :prospects="prospects" />
        </div>
    </AuthenticatedLayout>
</template>