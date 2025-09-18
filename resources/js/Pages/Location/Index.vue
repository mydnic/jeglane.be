<template>
    <AppLayout class="bg-slate-50">
        <Head>
            <title>
                Trouver un lieu de glanage
            </title>
            <link
                rel="canonical"
                :href="route('locations.index')"
            >
            <meta
                name="description"
                content="Trouvez un lieu de glanage en Belgique grâce à notre carte interactive et aux contributions de la communauté."
            >
            <meta
                property="og:type"
                content="website"
            >
            <meta
                property="og:title"
                content="Trouver un lieu de glanage"
            >
            <meta
                property="og:description"
                content="Carte interactive des lieux de glanage en Belgique. Photos, commentaires et votes."
            >
            <meta
                property="og:image"
                content="/logo.png"
            >
            <meta
                property="og:url"
                :content="route('locations.index')"
            >
            <meta
                name="twitter:card"
                content="summary_large_image"
            >
            <meta
                name="twitter:title"
                content="Trouver un lieu de glanage"
            >
            <meta
                name="twitter:description"
                content="Carte interactive des lieux de glanage en Belgique."
            >
            <meta
                name="twitter:image"
                content="/logo.png"
            >
        </Head>
        <div class="max-w-full mx-auto py-6 space-y-6 px-4 md:px-0">
            <div class="border-b border-gray-200 pb-5">
                <h3 class="text-base font-semibold leading-6 text-gray-900">
                    Trouver un lieu de glanage
                </h3>
            </div>

            <div class="space-y-6">
                <div class="flex md:flex-row flex-col md:h-[80vh] -mx-4">
                    <div class="order-last md:order-first h-full max-h-full md:w-1/2 xl:w-1/3 overflow-auto px-4">
                        <div class="flex-col space-y-4">
                            <div class="flex flex-col md:flex-row gap-3 md:items-center">
                                <div class="grow max-w-xl">
                                    <MultiSelect
                                        v-model="selectedCategories"
                                        :options="gleanables"
                                        option-label="name"
                                        option-value="id"
                                        display="comma"
                                        placeholder="Filtrer par catégorie"
                                        class="w-full"
                                        :max-selected-labels="3"
                                        @change="onCategoriesChanged"
                                    />
                                </div>
                                <Button
                                    v-if="selectedCategories.length"
                                    label="Réinitialiser"
                                    size="small"
                                    severity="secondary"
                                    icon="pi pi-filter-slash"
                                    @click="clearCategories"
                                />
                            </div>
                            <div
                                v-for="(item, index) in locations"
                                :key="index"
                            >
                                <Card>
                                    <template #content>
                                        <div>
                                            <div class="text-lg font-medium">
                                                {{ item.gleanable.name }}
                                            </div>
                                            <span class="font-medium text-surface-500 dark:text-surface-400 text-sm">
                                                {{ item.postal_code }} {{ item.city }}
                                            </span>
                                        </div>
                                        <div class="flex md:items-end mt-3 gap-3">
                                            <div class="text-sm text-surface-500 dark:text-surface-400 flex items-center gap-1">
                                                <i class="pi pi-thumbs-up" />
                                                {{ item.vote_count || 0 }}
                                            </div>
                                            <div class="grow" />
                                            <Button
                                                icon="pi pi-map-marker"
                                                size="small"
                                                @click="() => $refs.mainMap.centerOn(item.latitude, item.longitude)"
                                            />
                                            <Button
                                                as="Link"
                                                :href="`/locations/${item.id}`"
                                                icon="pi pi-external-link"
                                                outlined
                                                size="small"
                                            />
                                        </div>
                                    </template>
                                </Card>
                            </div>
                        </div>
                    </div>

                    <div class="w-full mb-6 md:mb-0 p-3 shadow-sm rounded-xl bg-white mr-4">
                        <Map
                            ref="mainMap"
                            class="w-full h-full min-h-[40vh]"
                            :markers="locations.map(l => ({
                                id: l.id,
                                latitude: l.latitude,
                                longitude: l.longitude,
                                html: `<h1>${l.description}</h1>`,
                                data: l
                            }))"
                            @center-changed="onCenterChanged"
                            @zoom-changed="onZoomChanged"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import debounce from 'lodash/debounce'
import AppLayout from '@/Layouts/AppLayout.vue'

export default {
    components: { AppLayout },
    props: ['locations', 'gleanables', 'filters'],

    data () {
        return {
            center: {
                latitude: 50.42279871790141,
                longitude: 4.529179174218756
            },
            zoom: 9,
            selectedCategories: []
        }
    },

    computed: {
        maxMeters () {
            const metersPerPixel = 156543.03392 * Math.cos(this.center.latitude * Math.PI / 180) / Math.pow(2, this.zoom)
            const mapHeight = this.$refs?.mainMap?.$el?.clientHeight
            const mapWidth = this.$refs?.mainMap?.$el?.clientWidth
            const distanceMax = (mapHeight + mapWidth) / 2
            return metersPerPixel * distanceMax
        }
    },

    methods: {
        onCategoriesChanged () {
            this.getLocations()
        },
        clearCategories () {
            this.selectedCategories = []
            this.getLocations()
        },
        onCenterChanged (center) {
            if (center.latitude === this.center.latitude && center.longitude === this.center.longitude) {
                return
            }
            this.center = center
            this.getLocations()
        },
        onZoomChanged (zoom) {
            this.zoom = zoom
            this.getLocations()
        },

        getLocations: debounce(function () {
            this.$inertia.get('/locations', {
                latitude: this.center.latitude,
                longitude: this.center.longitude,
                distance: this.maxMeters,
                categories: this.selectedCategories
            }, {
                preserveState: true,
                preserveScroll: true,
                replace: true
            })
        }, 500)
    },

    mounted () {
        // Initialize categories from query string (array or comma-separated string)
        const incoming = this.filters?.categories
        if (Array.isArray(incoming)) {
            this.selectedCategories = incoming.map(v => Number(v))
        } else if (typeof incoming === 'string' && incoming.length) {
            this.selectedCategories = incoming.split(',').map(v => Number(v)).filter(v => !Number.isNaN(v))
        }
    }
}
</script>
