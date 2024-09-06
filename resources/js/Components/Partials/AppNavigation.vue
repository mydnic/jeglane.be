<template>
    <Menubar
        :model="items"
    >
        <template #start>
            <img
                src="/logo.png"
                alt="Logo Jeglane.be"
                class="h-[40px] rounded-full"
            >
        </template>
        <template #end>
            <div
                v-if="$page.props.auth.user"
                class="flex items-center gap-2"
            >
                <Button
                    type="button"
                    text
                    :label="$page.props.auth.user.name"
                    severity="secondary"
                    aria-haspopup="true"
                    aria-controls="overlay_menu"
                    @click="toggle"
                />

                <Menu
                    id="overlay_menu"
                    ref="op"
                    :model="[
                        {
                            label: 'Profil',
                            icon: 'pi pi-user',
                            command: () => {
                                $inertia.visit('/user/profile');
                            }
                        },
                        {
                            label: 'Déconnexion',
                            icon: 'pi pi-sign-out',
                            command: () => {
                                $inertia.post('/logout');
                            }
                        }
                    ]"
                    popup
                />
            </div>

            <div
                v-else
                class="flex items-center gap-2"
            >
                <Button
                    type="button"
                    text
                    label="Connexion"
                    @click="$inertia.visit('/login')"
                />
                <Button
                    type="button"
                    label="Inscription"
                    @click="$inertia.visit('/register')"
                />
            </div>
        </template>
    </Menubar>
</template>

<script>
export default {
    name: 'AppNavigation',

    computed: {
        items () {
            return [
                {
                    label: 'Accueil',
                    icon: 'pi pi-home',
                    command: () => {
                        this.$inertia.visit('/')
                    }
                },
                {
                    label: 'Où glaner',
                    icon: 'pi pi-map-marker',
                    command: () => {
                        this.$inertia.visit('/locations')
                    }
                },
                {
                    label: 'Soumettre un lieu de glanage',
                    icon: 'pi pi-info-circle',
                    command: () => {
                        this.$inertia.visit('/locations/create')
                    }
                }
            ]
        }
    },

    methods: {
        toggle (event) {
            this.$refs.op.toggle(event)
        }
    }
}
</script>
