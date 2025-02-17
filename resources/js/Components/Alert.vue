<script setup>
import { defineProps } from 'vue';

// Define props
const props = defineProps({
    type: {
        type: String,
        required: true
    },
    message: {
        type: String,
        required: true
    }
});
</script>

<template>
    <div :class="`alert alert-${props.type}`">
        {{ props.message }}
    </div>
</template>

<style scoped>
.alert {
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid transparent;
    border-radius: 4px;
}
.alert-success {
    color: #3c763d;
    background-color: #dff0d8;
    border-color: #d6e9c6;
}
.alert-error {
    color: #a94442;
    background-color: #f2dede;
    border-color: #ebccd1;
}
</style>
