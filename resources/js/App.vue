<script setup>
import SideBar from '@/Components/SideBar.vue';
import { ref } from 'vue';

const drawer = ref(true);
const rail = ref(true);
</script>

<template>
    <v-app>
        <SideBar />

        <v-main>
            <slot />
        </v-main>
    </v-app>
</template>
