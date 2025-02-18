<template>
    <div v-if="showCreateModal" class="fixed inset-0 flex items-center justify-center z-50">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Create Department</h3>
                <form @submit.prevent="prepareAndSubmit">
                    <div class="mt-4">
                        <label for="department-name" class="block text-sm font-medium text-gray-700">
                            Department Name
                            <input id="department-name" name="department-name" type="text" v-model="createForm.name"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                        </label>
                        <InputError :message="createForm.errors.name" class="mt-2 text-sm text-red-600" />
                    </div>

                    <div class="mt-4">
                        <label for="department-description" class="block text-sm font-medium text-gray-700">
                            Description
                            <input id="department-description" name="department-description" type="text" v-model="createForm.description"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                        </label>
                        <InputError :message="createForm.errors.description" class="mt-2 text-sm text-red-600" />
                    </div>

                    <!-- Select Users -->
                    <div class="mt-4">
                        <span class="block text-sm font-medium text-gray-700">Select Users</span>
                        <div class="flex">
                            <!-- Available Users -->
                            <div class="w-1/2">
                                <h4 class="text-sm font-medium text-gray-900">Available Users</h4>
                                <ul class="mt-1 border border-gray-300 rounded-md shadow-sm overflow-auto h-32">
                                    <li v-for="user in availableUsers" :key="'available-' + user.id"
                                        class="px-3 py-2 border-b border-gray-200 cursor-pointer hover:bg-gray-100">
                                        <label class="flex items-center w-full cursor-pointer">
                                            <input type="checkbox" :id="'user-' + user.id" name="user-selection"
                                                class="hidden" @change="selectUser(user)">
                                            <span class="ml-2">{{ user.name }}</span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                            <!-- Selected Users -->
                            <div class="w-1/2">
                                <h4 class="text-sm font-medium text-gray-900">Selected Users</h4>
                                <ul class="mt-1 border border-gray-300 rounded-md shadow-sm overflow-auto h-32">
                                    <li v-for="member in selectedUsers" :key="'selected-' + member.id"
                                        class="px-3 py-2 border-b border-gray-200 cursor-pointer hover:bg-gray-100">
                                        <label class="flex items-center w-full cursor-pointer">
                                            <input type="checkbox" :id="'selected-' + member.id" name="selected-users"
                                                class="hidden" @change="removeUser(member)">
                                            <span class="ml-2">{{ member.name }}</span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Main Responsible User -->
                    <div class="mt-4" v-if="selectedUsers.length > 0">
                        <label for="main-responsible" class="block text-sm font-medium text-gray-700">
                            Select Main Responsible User
                            <select id="main-responsible" name="main-responsible" v-model="createForm.main_responsible"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option v-for="member in selectedUsers" :key="'main-responsible-' + member.id" :value="member.id">
                                    {{ member.name }}
                                </option>
                            </select>
                        </label>
                    </div>

                    <div v-if="!createForm.name || !createForm.description || selectedUsers.length === 0"
                        class="mt-4 text-sm text-red-600">
                        Please fill all required fields and select at least one user.
                    </div>

                    <div class="mt-4 flex items-center justify-end">
                        <SecondaryButton type="button" @click="closeCreateModalAndReset" class="me-2">
                            <i class="material-icons align-middle me-1">cancel</i>
                            Cancel
                        </SecondaryButton>
                        <PrimaryButton v-if="createForm.name && createForm.description && selectedUsers.length > 0"
                            type="submit" :class="{ 'opacity-25': createForm.processing }" :disabled="createForm.processing">
                            <i class="material-icons align-middle me-1">save</i>
                            Create
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    showCreateModal: Boolean,
    createForm: Object,
    users: Array,
    closeCreateModal: Function,
    submitCreate: Function
});

const selectedUsers = ref([]);
const availableUsers = computed(() => {
    return props.users.filter(user => !selectedUsers.value.some(selected => selected.id === user.id));
});

const resetForm = () => {
    props.createForm.name = '';
    props.createForm.description = '';
    props.createForm.main_responsible = null;
    selectedUsers.value = [];
};

const selectUser = (user) => {
    if (!selectedUsers.value.some(selected => selected.id === user.id)) {
        selectedUsers.value.push(user);
    }
};

const removeUser = (user) => {
    selectedUsers.value = selectedUsers.value.filter(selected => selected.id !== user.id);
};

const prepareAndSubmit = () => {
    if (selectedUsers.value.length === 0) {
        alert("Please select at least one member.");
        return;
    }
    props.createForm.members = selectedUsers.value.map(user => user.id);
    props.submitCreate();
    resetForm();
};

const closeCreateModalAndReset = () => {
    resetForm();
    props.closeCreateModal();
};

watch(() => props.showCreateModal, (newVal) => {
    if (newVal) {
        resetForm();
    }
});
</script>
