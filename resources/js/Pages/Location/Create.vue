<template>
    <Head>
        <title>
            Soumettre un lieu de glanage
        </title>
        <meta
            name="description"
            content="Soumettez un lieu de glanage pour que d'autres glaneurs puissent en profiter."
        >
    </Head>

    <AppLayout class="bg-slate-900/5">
        <div class="container mx-auto py-6 space-y-6 px-4 md:px-0">
            <div class="border-b border-gray-200 pb-5">
                <h3 class="text-base font-semibold leading-6 text-gray-900">
                    Soumettre un lieu de glanage
                </h3>
            </div>

            <Stepper
                value="1"
                linear
            >
                <StepList>
                    <Step value="1">
                        Lieu
                    </Step>
                    <Step value="2">
                        Description
                    </Step>
                    <Step value="3">
                        Photos
                    </Step>
                </StepList>
                <StepPanels>
                    <StepPanel
                        v-slot="{ activateCallback }"
                        value="1"
                    >
                        <Card>
                            <template #title>
                                Choisissez l'emplacement
                            </template>
                            <template #content>
                                <Map
                                    class="h-[50vh]"
                                    can-set-marker
                                    @current-position="onPositionChange"
                                />

                                <div class="space-y-3 mt-6">
                                    <div class="flex flex-col gap-1">
                                        <label for="username">Latitude</label>
                                        <InputText
                                            v-model="formData.latitude"
                                            type="text"
                                            size="small"
                                            required
                                            placeholder="Latitude"
                                        />
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label for="username">Longitude</label>
                                        <InputText
                                            v-model="formData.longitude"
                                            type="text"
                                            size="small"
                                            required
                                            placeholder="Longitude"
                                        />
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label for="username">Ville</label>
                                        <InputText
                                            v-model="formData.city"
                                            type="text"
                                            size="small"
                                            required
                                            placeholder="Ville"
                                        />
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label for="username">Code Postal</label>
                                        <InputText
                                            v-model="formData.postal_code"
                                            type="text"
                                            size="small"
                                            required
                                            placeholder="Code Postal"
                                        />
                                    </div>
                                </div>
                            </template>

                            <template #footer>
                                <div class="flex gap-4 mt-1">
                                    <Button
                                        label="Suivant"
                                        class="w-full"
                                        icon="pi pi-arrow-right"
                                        :disabled="!formData.latitude || !formData.longitude"
                                        @click="activateCallback('2')"
                                    />
                                </div>
                            </template>
                        </Card>
                    </StepPanel>

                    <StepPanel
                        v-slot="{ activateCallback }"
                        value="2"
                    >
                        <Card>
                            <template #title>
                                Donnez quelques détails
                            </template>
                            <template #content>
                                <div class="flex mt-6 flex-col gap-1">
                                    <label for="username">Que peut-on y trouver ?</label>
                                    <Select
                                        v-model="formData.gleanable_id"
                                        :options="gleanables"
                                        filter
                                        option-label="name"
                                        placeholder="Choisir une option"
                                        class="w-full md:w-56"
                                        required
                                    />
                                </div>

                                <div class="flex mt-6 flex-col gap-1">
                                    <label for="username">Un petit commentaire pour les autres glaneurs ?</label>
                                    <Textarea
                                        v-model="formData.description"
                                        placeholder="Décrivez le lieu, comment y accéder, ce que l'on peut y trouver, etc."
                                        class="w-full"
                                    />
                                </div>
                            </template>

                            <template #footer>
                                <div class="flex gap-4 mt-5">
                                    <Button
                                        label="Précédent"
                                        class="w-full"
                                        severity="secondary"
                                        icon="pi pi-arrow-left"
                                        @click="activateCallback('1')"
                                    />
                                    <Button
                                        label="Suivant"
                                        class="w-full"
                                        icon="pi pi-arrow-right"
                                        icon-pos="right"
                                        :disabled="!formData.gleanable_id"
                                        @click="activateCallback('3')"
                                    />
                                </div>
                            </template>
                        </Card>
                    </StepPanel>

                    <StepPanel
                        v-slot="{ activateCallback }"
                        value="3"
                    >
                        <Card>
                            <template #title>
                                Des photos ?
                            </template>
                            <template #content>
                                <div class="py-6">
                                    <FileUpload
                                        mode="basic"
                                        name="files[]"
                                        url="/api/upload"
                                        accept="image/*"
                                        :max-file-size="1000000"
                                        multiple
                                        :auto="true"
                                        choose-label="Choisir des photos"
                                        @upload="onUpload"
                                    />

                                    <div class="grid mt-6 grid-cols-2 gap-4 md:grid-cols-3">
                                        <div
                                            v-for="image in formData.fileUrls"
                                            class="relative flex-col flex items-center"
                                        >
                                            <img
                                                :src="image"
                                                alt="decoration"
                                            >
                                            <Button
                                                icon="pi pi-times"
                                                severity="danger"
                                                text
                                                rounded
                                                @click="formData.fileUrls = formData.fileUrls.filter((url) => url !== image)"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <template #footer>
                                <div class="flex gap-4 mt-5">
                                    <Button
                                        label="Précédent"
                                        class="w-full"
                                        severity="secondary"
                                        icon="pi pi-arrow-left"
                                        @click="activateCallback('2')"
                                    />
                                    <Button
                                        label="Soumettre"
                                        class="w-full"
                                        icon="pi pi-check"
                                        icon-pos="right"
                                        @click="submit"
                                    />
                                </div>
                            </template>
                        </Card>
                    </StepPanel>
                </StepPanels>
            </Stepper>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'

export default {
    components: { AppLayout },
    props: ['gleanables'],

    data () {
        return {
            formData: {
                latitude: null,
                longitude: null,
                city: null,
                postal_code: null,
                description: null,
                fileUrls: []
            },
            files: []
        }
    },

    methods: {
        onPositionChange (position) {
            this.formData.latitude = position.latitude
            this.formData.longitude = position.longitude
            this.formData.city = position.city
            this.formData.postal_code = position.postalCode
        },

        onUpload (event) {
            JSON.parse(event.xhr.response).files.forEach((file) => {
                this.formData.fileUrls.push(file)
            })
        },

        submit () {
            this.$inertia.post('/locations', {
                files: this.formData.fileUrls,
                gleanable_id: this.formData.gleanable_id.id,
                description: this.formData.description,
                latitude: this.formData.latitude,
                longitude: this.formData.longitude,
                city: this.formData.city,
                postal_code: this.formData.postal_code
            })
        }
    }
}
</script>
