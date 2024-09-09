<template>
    <AppLayout>
        <Head>
            <title>
                Glanage de {{ gleaningLocation.name }} - JeGlane.be
            </title>
            <meta
                name="description"
                content="Soumettez un lieu de glanage pour que d'autres glaneurs puissent en profiter."
            >
        </Head>
        <h1>{{ gleaningLocation }}</h1>

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
