<template>
    <AppLayout class="bg-slate-50">
        <Head>
            <title>Changelog</title>
            <meta
                name="description"
                content="Historique des modifications de l'application"
            >
        </Head>
        <div class="max-w-7xl mx-auto py-6 space-y-6 px-4 md:px-0">
            <div class="border-b border-gray-200 pb-5">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-semibold leading-6 text-gray-900">
                            Changelog
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Historique des modifications de l'application
                        </p>
                    </div>
                    <div>
                        <Button
                            as="a"
                            href="https://featureflow.tech/ask/cm3ea772c0001b2ubluwceqwi/forit"
                        >
                            Suggestions et idées d'amélioration
                        </Button>
                    </div>
                </div>
            </div>

            <div class="text-center" />

            <div class="bg-white shadow rounded-lg p-6">
                <div v-if="groupedChangelog && Object.keys(groupedChangelog).length > 0">
                    <div
                        v-for="date in Object.keys(groupedChangelog)"
                        :key="date"
                        class="mb-8 last:mb-0"
                    >
                        <h2 class="text-lg font-semibold text-gray-800 mb-3">
                            {{ formatDate(date) }}
                        </h2>
                        <ul class="list-disc pl-6 text-gray-600 space-y-2">
                            <li
                                v-for="item in groupedChangelog[date]"
                                :key="item.message"
                                class="text-sm"
                            >
                                {{ item.message }}
                            </li>
                        </ul>
                    </div>
                </div>
                <div
                    v-else
                    class="text-center text-gray-500 py-8"
                >
                    Aucun changement à afficher pour le moment.
                </div>

                <div
                    v-if="hasMorePages"
                    class="mt-8 flex justify-center"
                >
                    <Button
                        :loading="isLoading"
                        :disabled="isLoading"
                        class="w-full sm:w-auto"
                        @click="loadMore"
                    >
                        <i class="pi pi-refresh mr-2" />
                        Charger plus
                    </Button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import { defineComponent } from 'vue'
import { Head } from '@inertiajs/vue3'
import Button from 'primevue/button'
import AppLayout from '@/Layouts/AppLayout.vue'

export default defineComponent({
    components: {
        AppLayout,
        Head,
        Button
    },

    props: {
        changelogs: {
            type: Object,
            required: true
        }
    },

    data () {
        return {
            items: [],
            currentPage: 1,
            lastPage: 1,
            isLoading: false
        }
    },

    computed: {
        groupedChangelog () {
            return this.items.reduce((acc, item) => {
                const key = item.date
                if (!acc[key]) {
                    acc[key] = []
                }
                acc[key].push(item)
                return acc
            }, {})
        },

        hasMorePages () {
            return this.currentPage < this.lastPage
        }
    },

    created () {
        this.items = this.changelogs.data
        this.currentPage = this.changelogs.current_page
        this.lastPage = this.changelogs.last_page
    },

    methods: {
        formatDate (date) {
            return new Date(date).toLocaleDateString('fr-FR', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            })
        },

        async loadMore () {
            if (this.isLoading || !this.hasMorePages) return

            this.isLoading = true
            try {
                const response = await fetch(`/changelog?page=${this.currentPage + 1}`)
                const data = await response.json()

                this.items = [...this.items, ...data.data]
                this.currentPage = data.current_page
                this.lastPage = data.last_page
            } catch (error) {
                console.error('Error loading more items:', error)
            } finally {
                this.isLoading = false
            }
        }
    }
})
</script>
