<template>
    <button class="btn btn-primary" :disabled="disabled" :style="{width: width}">
        <i class="fas fa-save mr-2"></i> {{ text }}
        <span class="spinner" v-if="loading"></span>
    </button>
</template>

<script>
export default {
    props: {
        text: {
            type: String,
            required: true,
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        loading: {
            type: Boolean,
            default: false,
        },
        width: {
            required: false,
            type: String,
        }
    },
};
</script>
