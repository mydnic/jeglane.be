<template>
    <AppLayout class="bg-slate-50">
        <div class="p-4">
            <div class="md:hidden block pb-5">
                <h3 class="text-base font-semibold leading-6 text-gray-900">
                    Trouver un lieu de glanage
                </h3>
            </div>
            <div class="flex md:flex-row flex-col md:h-[90vh] md:p-8">
                <div class="order-last md:order-first h-full max-h-full md:w-1/2 xl:w-1/3 overflow-auto">
                    <Card>
                        <template #title>
                            Trouver un lieu
                        </template>
                        <template #content>
                            <DataView :value="locations">
                                <template #list="slotProps">
                                    <div class="flex flex-col">
                                        <div
                                            v-for="(item, index) in slotProps.items"
                                            :key="index"
                                        >
                                            <div
                                                class="flex flex-col md:flex-row sm:items-center py-3 gap-4"
                                                :class="{ 'border-t border-surface-200 dark:border-surface-700': index !== 0 }"
                                            >
                                                <img
                                                    class="block xl:block mx-auto rounded w-full md:w-1/4 shrink-0"
                                                    :src="`${item.files[0]}`"
                                                    :alt="item.name"
                                                >
                                                <div class="flex flex-col md:flex-row justify-between md:items-center flex-1 gap-6">
                                                    <div class="text-center">
                                                        <span class="font-medium text-surface-500 dark:text-surface-400 text-sm">
                                                            {{ item.postal_code }} {{ item.city }}
                                                        </span>
                                                        <div class="text-lg font-medium mt-2">
                                                            {{ item.gleanable.name }}
                                                        </div>
                                                    </div>
                                                    <div class="flex md:items-end gap-8">
                                                        <Button
                                                            icon="pi pi-map-marker"
                                                            label="Voir sur la carte"
                                                            size="small"
                                                            @click="() => $refs.mainMap.centerOn(item.latitude, item.longitude)"
                                                        />
                                                        <Button
                                                            as="Link"
                                                            :href="`/locations/${item.id}`"
                                                            icon="pi pi-external-link"
                                                            outlined
                                                            label="Ouvrir le détail"
                                                            size="small"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </DataView>
                        </template>
                    </Card>
                </div>

                <div class="w-full mb-6 md:mb-0 p-3 shadow-sm rounded-xl bg-white">
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
