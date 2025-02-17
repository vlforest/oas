<script setup>
import NavLink from "@/Components/NavLink.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import { usePage } from "@inertiajs/vue3";

// Truy cập trực tiếp vào thông tin người dùng từ Inertia
const page = usePage();
const userRole = page.props.auth.user.role;
</script>
<template>
    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
        <NavLink
            :href="route('dashboard')"
            :active="route().current('dashboard')"
        >
            <i class="material-icons align-middle me-2">dashboard</i>
            Dashboard
        </NavLink>
        <template v-if="userRole === 'Administrator'">
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
                                    <i class="material-icons me-2">settings</i>
                                    Management
                                    <span class="material-icons ms-2"
                                        >arrow_drop_down</span
                                    >
                                </button>
                            </span>
                        </template>

                        <template #content>
                            <DropdownLink
                                :href="route('users.index')"
                                class="block px-4 py-2 text-sm text-gray-700"
                            >
                                <i class="material-icons align-middle me-2"
                                    >manage_accounts</i
                                >
                                User
                            </DropdownLink>
                            <DropdownLink
                                :href="route('departments.index')"
                                class="block px-4 py-2 text-sm text-gray-700"
                            >
                                <i class="material-icons align-middle me-2"
                                    >business</i
                                >
                                Department
                            </DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </div>
        </template>
    </div>
</template>
