<script setup>
import {onMounted, ref, watch} from 'vue';
import { usePage, Link } from '@inertiajs/vue3';
import {createCookie, readCookie, userHasPermission} from "@/helpers.js";

const drawer = ref(true);
const rail = ref(false);

const { props } = usePage();

const openSidebar = () => {
    createCookie('sidebar', '', -1);
    rail.value = !rail.value;
};

const closeSidebar = () => {
    createCookie('sidebar', '', -1);
    rail.value = true;
};

// onMounted(() => {
//     if (readCookie('sidebar')) {
//         rail.value = true;
//     }
// });
</script>

<template>
    <v-navigation-drawer
        v-model="drawer"
        width="200"
        :rail="rail"
    >
        <v-card class="d-flex flex-column justify-space-between" style="height: 100%;">
            <div>
                <v-list-item class="align-self-center mb-2" v-if="rail">
                    <v-icon color="grey">mdi-account</v-icon>
                </v-list-item>

                <v-list-item
                    class="align-self-center ml-2"
                    v-else
                    :title="`Hello, ${props.auth.user.name}`"
                    @click="openSidebar"
                    nav
                >
                    <template v-slot:append>
                        <v-btn
                            icon="mdi-chevron-left"
                            variant="text"
                        ></v-btn>
                    </template>
                </v-list-item>

                <v-divider></v-divider>

                <v-list density="compact" nav>
                    <v-list-item
                        :href="route('dashboard')"
                        prepend-icon="mdi-home-city"
                        title="Dashboard"
                        value="dashboard"
                    ></v-list-item>

                    <v-list-item
                        :href="route('prospects.index')"
                        prepend-icon="mdi-face-agent"
                        title="Prospects"
                        value="prospects"
                    ></v-list-item>

                    <v-list-item
                        :href="route('orders.index')"
                        prepend-icon="mdi-shopping"
                        title="Orders"
                        value="orders"
                    ></v-list-item>

                    <v-list-group
                        value="Admin"
                    >
                        <template v-slot:activator="{ props }">
                            <v-list-item
                                prepend-icon="mdi-account-circle"
                                v-bind="props"
                                title="Admin"
                            ></v-list-item>
                        </template>

                        <v-list-item
                            :href="route('users.index')"
                            title="Users"
                            value="users"
                        ></v-list-item>
                    </v-list-group>


                </v-list>
            </div>

            <v-list-item class="align-self-center mb-2" v-if="rail">
                <v-icon color="red">mdi-logout</v-icon>
            </v-list-item>

            <v-list-item class="align-self-center mb-2" v-else>
                <Link :href="route('logout')" method="post" as="button" class="v-list-item__link">
                    <v-btn
                        prepend-icon="mdi-logout"
                        color="red"
                    >
                        logout
                    </v-btn>
                </Link>
            </v-list-item>
        </v-card>
    </v-navigation-drawer>
</template>
