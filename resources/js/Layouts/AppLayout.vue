<script setup>
import { Head } from '@inertiajs/vue3'

defineProps({
    title: String
})
</script>

<template>
    <div class="h-screen flex flex-col">
        <Head :title="title" />

        <AppNavigation />

        <!-- Page Content -->
        <main class="grow overflow-auto">
            <slot />
            <AppFooter />
        </main>
        <Toast />
    </div>
</template>
