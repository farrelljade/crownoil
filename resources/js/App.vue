<script setup>
import SideBar from '@/Components/SideBar.vue';
</script>

<template>
    <v-app>
        <SideBar />

        <v-main>
            <slot />
        </v-main>
    </v-app>
</template>
