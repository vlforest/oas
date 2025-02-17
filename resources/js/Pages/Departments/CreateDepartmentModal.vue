<template>
    <div v-if="showCreateModal" class="fixed inset-0 flex items-center justify-center z-50">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Create Department</h3>
                <form @submit.prevent="submitCreate">
                    <div class="mt-4">
                        <InputLabel for="create-name" value="Department Name" />
                        <TextInput id="create-name" type="text" v-model="createForm.name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required autofocus />
                        <InputError :message="createForm.errors.name" class="mt-2 text-sm text-red-600" />
                    </div>
                    <div class="mt-4">
                        <InputLabel for="create-description" value="Description" />
                        <TextInput id="create-description" type="text" v-model="createForm.description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                        <InputError :message="createForm.errors.description" class="mt-2 text-sm text-red-600" />
                    </div>
                    <div v-if="!createForm.name || !createForm.description" class="mt-4 text-sm text-red-600">
                        Both fields are required.
                    </div>
                    <div class="mt-4 flex items-center justify-end">
                        <SecondaryButton type="button" @click="closeCreateModal" class="me-2">
                            <i class="material-icons align-middle me-1">cancel</i>
                            Cancel
                        </SecondaryButton>
                        <PrimaryButton v-if="createForm.name && createForm.description" type="submit" :class="{ 'opacity-25': createForm.processing }" :disabled="createForm.processing">
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
import { ref } from 'vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    showCreateModal: Boolean,
    createForm: Object,
    closeCreateModal: Function,
    submitCreate: Function
});
</script>
