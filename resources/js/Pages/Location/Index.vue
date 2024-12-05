<template>
    <AppLayout class="bg-slate-50">
        <Head>
            <title>
                Trouver un lieu de glanage
            </title>
            <meta
                name="description"
                content="Trouvez un lieu de glanage en Belgique"
            >
        </Head>
        <div class="max-w-7xl mx-auto py-6 space-y-6 px-4 md:px-0">
            <div class="border-b border-gray-200 pb-5">
                <h3 class="text-base font-semibold leading-6 text-gray-900">
                    Trouver un lieu de glanage
                </h3>
            </div>

            <div>
                <div class="flex md:flex-row flex-col md:h-[80vh] -mx-4">
                    <div class="order-last md:order-first h-full max-h-full md:w-1/2 xl:w-1/3 overflow-auto px-4">
                        <div class="flex-col space-y-4">
                            <div
                                v-for="(item, index) in locations"
                                :key="index"
                            >
                                <Card
                                    class="py-3"
                                    :class="{ 'border-t border-surface-200 dark:border-surface-700': index !== 0 }"
                                >
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
                                                <i class="pi pi-thumbs-up"></i>
                                                {{ item.vote_count || 0 }}
                                            </div>
                                            <div class="grow"></div>
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
                                    <!--                                                <img -->
                                    <!--                                                    class="block xl:block mx-auto rounded w-full md:w-1/4 shrink-0" -->
                                    <!--                                                    :src="`${item.files[0]}`" -->
                                    <!--                                                    :alt="item.name" -->
                                    <!--                                                > -->
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
    props: ['locations'],

    data () {
        return {
            center: {
                latitude: 50.5000386,
                longitude: 3.8068281
            },
            zoom: 9
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
                distance: this.maxMeters
            }, {
                preserveState: true,
                preserveScroll: true
            })
        }, 500)
    }
}
</script>
