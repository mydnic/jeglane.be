<template>
    <AppLayout>
        <Head>
            <title>
                Glanage de {{ gleaningLocation.gleanable.name }} - JeGlane.be
            </title>
            <meta
                name="description"
                :content="`Glanage de ${gleaningLocation.gleanable.name} à ${gleaningLocation.city} (${gleaningLocation.postal_code})`"
            >
        </Head>
        <h1>
            Glanage de {{ gleaningLocation.gleanable.name }} à {{ gleaningLocation.city }} ({{ gleaningLocation.postal_code }})
        </h1>

        <Galleria
            :value="gleaningLocation.files"
            :responsive-options="responsiveOptions"
            :num-visible="5"
            container-style="max-width: 640px"
        >
            <template #item="slotProps">
                <img
                    :src="slotProps.item"
                    alt="Photo"
                    style="width: 100%"
                >
            </template>
        </Galleria>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'

export default {
    components: { AppLayout },
    props: ['gleaningLocation']
}
</script>
