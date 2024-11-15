<script setup>
import { Head } from '@inertiajs/vue3'

defineProps({
    title: String
})
</script>

<template>
    <div>
        <Head :title="title" />

        <AppNavigation />

        <!-- Page Content -->
        <main class="pt-16 px-4">
            <slot />
            <AppFooter />
        </main>
        <Toast />
    </div>
</template>
