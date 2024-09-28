<script setup>

const emit = defineEmits(['onCancel', 'confirm']);

const props = defineProps({
    text: {
        type: String,
        default: "Please confirm"
    },
    title: {
        type: String,
        default: "Confirm"
    },
    disabled: {
        type: Boolean,
        default: false
    }
});

const cancel = () => {
    emit('onCancel');
}

const confirm = () => {
    emit('confirm');
}
</script>

<template>
    <v-card>
        <v-card-title class="bg-primary mb-5 d-flex justify-space-between align-center">
            {{ title }}
        </v-card-title>

        <v-card-text class="text-center">
            <span class="subtitle-1">{{ text }}</span>
        </v-card-text>

        <v-card-actions>
            <v-btn
                @click="cancel"
            >Cancel</v-btn>
            <v-btn
                @click="confirm"
                color="primary"
                :disabled="disabled"
            >Confirm</v-btn>
        </v-card-actions>
    </v-card>
</template>
