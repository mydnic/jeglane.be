<template>
    <AppLayout>
        <h1>{{ gleaningLocation }}</h1>

        <Galleria
            :value="images"
            :responsive-options="responsiveOptions"
            :num-visible="5"
            container-style="max-width: 640px"
        >
            <template #item="slotProps">
                <img
                    :src="slotProps.item.itemImageSrc"
                    :alt="slotProps.item.alt"
                    style="width: 100%"
                >
            </template>
            <template #thumbnail="slotProps">
                <img
                    :src="slotProps.item.thumbnailImageSrc"
                    :alt="slotProps.item.alt"
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
