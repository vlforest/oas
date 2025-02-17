<script setup>
import { Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
</script>

<template>
    <div class="flex shrink-0 items-center">
        <Link :href="route('dashboard')">
            <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800" />
        </Link>
    </div>
</template>
