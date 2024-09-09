<template>
    <AppLayout>
        <div class="flex h-[90vh] bg-slate-50 p-4 md:p-8">
            <div class="h-full max-h-full w-1/3 overflow-auto">
                <Card style="width: 25rem; overflow: hidden">
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
                                            class="flex flex-col sm:flex-row sm:items-center p-6 gap-4"
                                            :class="{ 'border-t border-surface-200 dark:border-surface-700': index !== 0 }"
                                        >
                                            <div class="md:w-40 relative">
                                                <img
                                                    class="block xl:block mx-auto rounded w-full"
                                                    :src="`${item.files[0]}`"
                                                    :alt="item.name"
                                                >
                                            </div>
                                            <div class="flex flex-col md:flex-row justify-between md:items-center flex-1 gap-6">
                                                <div class="flex flex-row md:flex-col justify-between items-start gap-2">
                                                    <div>
                                                        <span class="font-medium text-surface-500 dark:text-surface-400 text-sm">{{ item.category }}</span>
                                                        <div class="text-lg font-medium mt-2">
                                                            {{ item.name }}
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="bg-surface-100 p-1"
                                                        style="border-radius: 30px"
                                                    >
                                                        <div
                                                            class="bg-surface-0 flex items-center gap-2 justify-center py-1 px-2"
                                                            style="border-radius: 30px; box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.04), 0px 1px 2px 0px rgba(0, 0, 0, 0.06)"
                                                        >
                                                            <span class="text-surface-900 font-medium text-sm">{{ item.rating }}</span>
                                                            <i class="pi pi-star-fill text-yellow-500" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex flex-col md:items-end gap-8">
                                                    <span class="text-xl font-semibold">${{ item.price }}</span>
                                                    <div class="flex flex-row-reverse md:flex-row gap-2">
                                                        <Button
                                                            icon="pi pi-heart"
                                                            outlined
                                                        />
                                                        <Button
                                                            icon="pi pi-shopping-cart"
                                                            label="Buy Now"
                                                            :disabled="item.inventoryStatus === 'OUTOFSTOCK'"
                                                            class="flex-auto md:flex-initial whitespace-nowrap"
                                                        />
                                                    </div>
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

            <div class="w-full p-3 border rounded-xl shadow bg-white">
                <Map
                    class="w-full h-full"
                    :markers="locations.map(l => ({
                        latitude: l.latitude,
                        longitude: l.longitude,
                        html: `<h1>${l.description}</h1>`,
                        data: l
                    }))"
                />
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'

export default {
    components: { AppLayout },
    props: ['locations']
}
</script>
