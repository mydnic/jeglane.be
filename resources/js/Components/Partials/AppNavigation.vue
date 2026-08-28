<template>
    <div class="fixed w-full z-20 flex items-center gap-4 px-4 py-2 bg-default border-b border-default">
        <img
            src="/logo.png"
            alt="Logo Jeglane.be"
            class="h-[40px] rounded-full"
        >

        <UNavigationMenu
            :items="items"
            class="grow"
        />

        <div
            v-if="$page.props.auth.user"
            class="flex items-center gap-2"
        >
            <UDropdownMenu :items="userItems">
                <UButton
                    type="button"
                    variant="ghost"
                    color="neutral"
                >
                    <UAvatar
                        :src="$page.props.auth.user.profile_photo_url"
                        size="xs"
                    />
                    {{ $page.props.auth.user.name }}
                </UButton>
            </UDropdownMenu>
        </div>

        <div
            v-else
            class="flex items-center gap-2"
        >
            <UButton
                type="button"
                variant="ghost"
                label="Connexion"
                @click="$inertia.visit('/login')"
            />
            <UButton
                type="button"
                label="Inscription"
                @click="$inertia.visit('/register')"
            />
        </div>
    </div>
</template>

<script>
export default {
    name: 'AppNavigation',

    computed: {
        currentPath () {
            return this.$page.url.split('?')[0]
        },

        items () {
            return [
                {
                    label: 'Accueil',
                    icon: 'i-lucide-house',
                    to: '/',
                    active: this.currentPath === '/'
                },
                {
                    label: 'Où glaner',
                    icon: 'i-lucide-map-pin',
                    to: '/locations',
                    active: this.currentPath === '/locations' || (this.currentPath.startsWith('/locations/') && this.currentPath !== '/locations/create')
                },
                {
                    label: 'Soumettre un lieu de glanage',
                    icon: 'i-lucide-info',
                    to: '/locations/create',
                    active: this.currentPath === '/locations/create'
                }
            ]
        },

        userItems () {
            return [
                {
                    label: 'Profil',
                    icon: 'i-lucide-user',
                    to: '/user/profile'
                },
                {
                    label: 'Déconnexion',
                    icon: 'i-lucide-log-out',
                    onSelect: () => {
                        this.$inertia.post('/logout')
                    }
                }
            ]
        }
    }
}
</script>
