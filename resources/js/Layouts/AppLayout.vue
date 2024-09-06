<script setup>
import { ref } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import ApplicationMark from '@/Components/ApplicationMark.vue'
import Banner from '@/Components/Banner.vue'
import Dropdown from '@/Components/Dropdown.vue'
import DropdownLink from '@/Components/DropdownLink.vue'
import NavLink from '@/Components/NavLink.vue'
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue'

defineProps({
    title: String
})

const showingNavigationDropdown = ref(false)

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id
    }, {
        preserveState: false
    })
}

const logout = () => {
    router.post(route('logout'))
}
</script>

<template>
    <div class="h-screen flex flex-col">
        <Head :title="title" />

        <AppNavigation />

        <!-- Page Content -->
        <main class="grow">
            <slot />
        </main>
        <Toast />
    </div>
</template>
