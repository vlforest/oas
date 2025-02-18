<template>
    <div class="relative">
        <button 
            v-if="!loading"
            class="fixed bg-blue-500 text-white rounded-full w-14 h-14 flex items-center justify-center shadow-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            :style="createButtonStyle"
            @mousedown="startDrag"
            @click="openCreateModal"
        >
            <i class="material-icons">add</i>
        </button>

        <div v-if="loading" class="flex justify-center items-center py-4">
            <svg class="animate-spin h-8 w-8 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291a7.963 7.963 0 01-2-5.291H0c0 2.21.897 4.21 2.343 5.657l1.657-1.366z"></path>
            </svg>
        </div>
        <div v-if="!loading && departments.length === 0" class="text-center py-4">
            <p class="text-gray-500">There are no departments available.</p>
        </div>
        <div v-if="!loading && departments.length > 0">
            <table class="min-w-full leading-normal table-fixed">
                <thead>
                    <tr>
                        <th class="w-1/6 px-5 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                        <th class="w-1/6 px-5 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Description</th>
                        <th class="w-1/2 px-5 py-2 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Members</th>
                        <th class="w-1/6 px-5 py-2 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Main Responsible</th>
                        <th class="w-1/12 px-5 py-2 border-b border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(department, index) in departments" :key="department.id" :class="{'bg-gray-50': index % 2 !== 0, 'bg-white': index % 2 === 0}">
                        <td class="px-5 py-2 border-b border-gray-200 text-sm">{{ department.name }}</td>
                        <td class="px-5 py-2 border-b border-gray-200 text-sm">{{ department.description }}</td>
                        <td class="px-5 py-2 border-b border-gray-200 text-sm">
                            <span>{{ department.members.map(member => getUserName(member)).join(', ') }}</span>
                        </td>
                        <td class="px-5 py-2 border-b border-gray-200 text-sm">{{ getUserName(department.main_responsible) }}</td>
                        <td class="px-5 py-2 border-b border-gray-200 text-sm text-center flex justify-center space-x-2">
                            <button 
                                @click="editDepartment(department)" 
                                class="bg-yellow-500 text-white rounded-full w-10 h-10 flex items-center justify-center shadow-lg hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500"
                            >
                                <i class="material-icons">edit</i>
                            </button>
                            <button 
                                @click="confirmDeleteDepartment(department)" 
                                class="bg-red-500 text-white rounded-full w-10 h-10 flex items-center justify-center shadow-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                            >
                                <i class="material-icons">delete</i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const props = defineProps({
    departments: Array,
    loading: Boolean,
    openCreateModal: Function,
    editDepartment: Function,
    confirmDeleteDepartment: Function,
    users: { type: Array, default: () => [] } 
});

const createButtonStyle = ref({
    top: '80%',
    left: '90%',
    position: 'fixed'
});

let dragging = false;
let startX, startY, initialTop, initialLeft;
let isClick = false;

onMounted(() => {
    const savedTop = localStorage.getItem('createButtonTop');
    const savedLeft = localStorage.getItem('createButtonLeft');
    if (savedTop && savedLeft) {
        createButtonStyle.value.top = savedTop;
        createButtonStyle.value.left = savedLeft;
    }
});

const startDrag = (event) => {
    dragging = true;
    isClick = true;
    startX = event.clientX;
    startY = event.clientY;
    initialTop = parseInt(createButtonStyle.value.top, 10);
    initialLeft = parseInt(createButtonStyle.value.left, 10);

    document.addEventListener('mousemove', onDrag);
    document.addEventListener('mouseup', stopDrag);
};

const onDrag = (event) => {
    if (dragging) {
        const deltaX = event.clientX - startX;
        const deltaY = event.clientY - startY;

        if (Math.abs(deltaX) > 5 || Math.abs(deltaY) > 5) {
            isClick = false;
        }

        createButtonStyle.value.top = `${initialTop + deltaY}px`;
        createButtonStyle.value.left = `${initialLeft + deltaX}px`;
    }
};

const stopDrag = () => {
    dragging = false;
    document.removeEventListener('mousemove', onDrag);
    document.removeEventListener('mouseup', stopDrag);

    localStorage.setItem('createButtonTop', createButtonStyle.value.top);
    localStorage.setItem('createButtonLeft', createButtonStyle.value.left);
};

const getUserName = (id) => {
    if (!props.users || props.users.length === 0) return 'N/A';
    const user = props.users.find(user => user.id === id);
    return user ? user.name : 'N/A';
};
</script>
