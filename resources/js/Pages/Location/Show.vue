<template>
    <AppLayout class="bg-slate-50">
        <Head>
            <title>
                Glanage de {{ gleaningLocation.gleanable.name }} - JeGlane.be
            </title>
            <meta
                name="description"
                :content="`Glanage de ${gleaningLocation.gleanable.name} à ${gleaningLocation.postal_code} ${gleaningLocation.city}`"
            >
        </Head>
        <div class="px-4 container grid lg:grid-cols-2 gap-6 mx-auto py-8">
            <div class="flex justify-between lg:col-span-2 items-center">
                <h1 class="text-xl">
                    Glanage de {{ gleaningLocation.gleanable.name }} à {{ gleaningLocation.postal_code }} {{ gleaningLocation.city }}
                </h1>
                <p class="text-sm text-gray-500">
                    {{ $dayjs(gleaningLocation.created_at).format('DD/MM/YYYY') }}
                </p>
            </div>

            <Map
                ref="mainMap"
                class="h-[50vh] lg:col-span-2"
                can-set-marker
                :markers="[{
                    id: gleaningLocation.id,
                    latitude: gleaningLocation.latitude,
                    longitude: gleaningLocation.longitude,
                    html: `<h1>${gleaningLocation.description}</h1>`,
                    data: gleaningLocation
                }]"
            />

            <Galleria
                :value="gleaningLocation.files"
                container-style="max-width: 640px;max-height: 400px"
                :show-thumbnails="false"
                :show-item-navigators="true"
                circular
            >
                <template #item="slotProps">
                    <img
                        :src="slotProps.item"
                        alt="Photo"
                        style="width: 100%;max-height: 400px"
                        class="object-cover"
                    >
                </template>
            </Galleria>

            <Card>
                <template #title>
                    Soumis par {{ gleaningLocation.user.name }}
                </template>
                <template #subtitle>
                    Le {{ $dayjs(gleaningLocation.created_at).format('DD/MM/YYYY') }}
                </template>

                <template #content>
                    <p class="m-0">
                        {{
                            gleaningLocation.description
                                ? gleaningLocation.description
                                : 'Aucune description'
                        }}
                    </p>
                </template>
            </Card>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'

export default {
    components: { AppLayout },
    props: ['gleaningLocation'],

    created () {
        setTimeout(() => {
            this.$refs.mainMap.centerOn(this.gleaningLocation.latitude, this.gleaningLocation.longitude)
        }, 1000)
    }
}
</script>
