<template>
    <div v-if="showEditModal" class="fixed inset-0 flex items-center justify-center z-50">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Department</h3>
                <form @submit.prevent="submitEdit">
                    <div class="mt-4">
                        <InputLabel for="edit-name" value="Department Name" />
                        <TextInput id="edit-name" type="text" v-model="form.name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required autofocus />
                        <InputError :message="form.errors.name" class="mt-2 text-sm text-red-600" />
                    </div>
                    <div class="mt-4">
                        <InputLabel for="edit-description" value="中文" />
                        <TextInput id="edit-description" type="text" v-model="form.description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                        <InputError :message="form.errors.description" class="mt-2 text-sm text-red-600" />
                    </div>
                    <div class="mt-4 flex items-center justify-end">
                        <SecondaryButton type="button" @click="closeEditModal" class="me-2">
                            <i class="material-icons align-middle me-1">cancel</i>
                            Cancel
                        </SecondaryButton>
                        <PrimaryButton type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            <i class="material-icons align-middle me-1">save</i>
                            Save Changes
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
    showEditModal: Boolean,
    form: Object,
    closeEditModal: Function,
    submitEdit: Function
});
</script>
