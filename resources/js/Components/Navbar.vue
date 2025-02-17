<script setup>
import Logo from '@/Components/Logo.vue';
import PrimaryNavigation from '@/Components/PrimaryNavigation.vue';
import SettingsDropdown from '@/Components/SettingsDropdown.vue';
import HamburgerMenu from '@/Components/HamburgerMenu.vue';
import ResponsiveNavbar from '@/Components/ResponsiveNavbar.vue';
import { ref } from 'vue';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <nav class="border-b border-gray-100 bg-white">
        <!-- Primary Navigation Menu -->
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 justify-between">
                <div class="flex">
                    <!-- Logo -->
                    <Logo />
                    <!-- Navigation Links -->
                    <PrimaryNavigation />
                </div>
                <!-- Settings Dropdown -->
                <SettingsDropdown />
                <!-- Hamburger -->
                <HamburgerMenu />
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <ResponsiveNavbar :showingNavigationDropdown="showingNavigationDropdown" />
    </nav>
</template>
