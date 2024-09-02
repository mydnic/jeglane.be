<template>
    <AppLayout>
        <div class="flex h-[90vh]">
            <div class="h-full max-h-full w-1/4 overflow-auto">{{ locations }}</div>

            <Map
                class="w-full"
                :markers="locations.map(l => ({
                    latitude: l.latitude,
                    longitude: l.longitude,
                    html: `<h1>${l.description}</h1>`,
                    data: l
                }))"
            />
        </div>

    </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";

export default {
    components: {AppLayout},
    props: ['locations']
}
</script>
