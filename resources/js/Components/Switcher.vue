<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    modelValue: Boolean,
    disabled: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['update:modelValue']);

const isActive = ref(props.modelValue);

watch(() => props.modelValue, (newValue) => {
    isActive.value = newValue;
});

function toggle() {
    if (!props.disabled) {
        emit('update:modelValue', !isActive.value);
    }
}
</script>

<template>
    <button
        :class="['switcher', { 'switcher--active': isActive, 'switcher--disabled': disabled }]"
        @click="toggle"
    >
        <span class="switcher__thumb"></span>
    </button>
</template>

<style scoped>
.switcher {
    position: relative;
    width: 42px;
    height: 24px;
    border-radius: 12px;
    background-color: #ccc;
    cursor: pointer;
    transition: background-color 0.3s;
}
.switcher--active {
    background-color: #4caf50;
}
.switcher--disabled {
    cursor: not-allowed;
    opacity: 0.5;
}
.switcher__thumb {
    position: absolute;
    top: 2px;
    left: 2px;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background-color: white;
    transition: transform 0.3s;
}
.switcher--active .switcher__thumb {
    transform: translateX(18px);
}
</style>
