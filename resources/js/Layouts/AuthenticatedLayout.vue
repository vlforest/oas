<script setup>
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100 flex flex-col justify-between">
            <div class="sticky top-0 z-50">
                <Navbar />
                <header class="bg-white shadow" v-if="$slots.header">
                    <div class="mx-auto max-w-7xl px-4 py-2 sm:px-4 lg:px-6">
                        <slot name="header" />
                    </div>
                </header>
            </div>

            <!-- Page Content -->
            <main class="flex-grow px-4 sm:px-6 lg:px-8 py-4">
                <slot />
            </main>

            <!-- Sticky Footer -->
            <footer class="sticky bottom-0">
                <Footer />
            </footer>
        </div>
    </div>
</template>
