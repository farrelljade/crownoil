<script setup>
import { ref } from 'vue';
import { usePage, Link } from '@inertiajs/vue3';  // Import Link from Inertia.js

const drawer = ref(true);
const rail = ref(true);

const { props } = usePage();
</script>

<template>
    <v-navigation-drawer
        v-model="drawer"
        :rail="rail"
        permanent
        @click="rail = false"
        app
    >
        <v-flex class="d-flex flex-column justify-space-between" style="height: 100%;">
            <div>
                <!-- User Info -->
                <v-list-item class="align-self-center mb-2" v-if="rail">
                    <v-list-item-icon>
                        <v-icon color="grey">mdi-account</v-icon>
                    </v-list-item-icon>
                </v-list-item>

                <v-list-item class="align-self-center ml-2" v-else="!rail"
                    :title="`Hello, ${props.auth.user.name}`"
                    nav
                >
                    <template v-slot:append>
                        <v-btn
                            icon="mdi-chevron-left"
                            variant="text"
                            @click.stop="rail = !rail"
                        ></v-btn>
                    </template>
                </v-list-item>

                <v-divider></v-divider>

                <v-list density="compact" nav>
                    <v-list-item
                        :href="route('dashboard')"
                        prepend-icon="mdi-home-city"
                        title="Home"
                        value="home"
                    ></v-list-item>

                    <v-list-item
                        :href="route('prospects.index')"
                        prepend-icon="mdi-face-agent"
                        title="Prospects"
                        value="prospects"
                    ></v-list-item>
                </v-list>
            </div>

            <v-list-item class="align-self-center mb-2" v-if="rail">
                <v-list-item-icon>
                    <v-icon color="red">mdi-logout</v-icon>
                </v-list-item-icon>
            </v-list-item>

            <v-list-item class="align-self-center mb-2" v-else="!rail">
                <Link :href="route('logout')" method="post" as="button" class="v-list-item__link">
                    <v-btn
                        prepend-icon="mdi-logout"
                        color="red"
                    >
                        logout
                    </v-btn>
                </Link>
            </v-list-item>
        </v-flex>
    </v-navigation-drawer>
</template>
