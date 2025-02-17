<script setup>
import { ref } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div class="hidden sm:ms-6 sm:flex sm:items-center">
        <!-- Settings Dropdown -->
        <div class="relative ms-3">
            <Dropdown align="right" width="48">
                <template #trigger>
                    <span class="inline-flex rounded-md">
                        <button
                            type="button"
                            class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                        >
                            <span class="material-icons me-2 text-gray-500">account_circle</span>
                            Hi, {{ $page.props.auth.user.name }}
                            <span class="material-icons ms-2">arrow_drop_down</span>
                        </button>
                    </span>
                </template>

                <template #content>
                    <DropdownLink :href="route('profile.edit')">
                        <span class="material-icons me-2">person</span> Profile
                    </DropdownLink>
                    <DropdownLink :href="route('logout')" method="post" as="button">
                        <span class="material-icons me-2">logout</span> Log Out
                    </DropdownLink>
                </template>
            </Dropdown>
        </div>
    </div>
</template>
