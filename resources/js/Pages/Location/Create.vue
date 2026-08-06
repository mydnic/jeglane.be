<template>
    <AppLayout class="bg-slate-50">
        <Head>
            <title>
                Soumettre un lieu de glanage
            </title>
            <meta
                name="description"
                content="Soumettez un lieu de glanage pour que d'autres glaneurs puissent en profiter."
            >
        </Head>
        <div class="container mx-auto py-6 space-y-6">
            <div class="border-b border-gray-200 pb-5">
                <h3 class="text-base font-semibold leading-6 text-gray-900">
                    Soumettre un lieu de glanage
                </h3>
            </div>

            <UStepper
                ref="stepper"
                v-model="step"
                :items="steps"
                linear
            >
                <template #place>
                    <UCard>
                        <template #title>
                            Choisissez l'emplacement
                        </template>

                        <template #default>
                            <Map
                                class="h-[50vh]"
                                can-set-marker
                                @current-position="onPositionChange"
                            />

                            <div class="space-y-3 mt-6">
                                <UFormField
                                    label="Latitude"
                                    :error="$page.props.errors?.latitude"
                                >
                                    <UInput
                                        v-model="formData.latitude"
                                        type="text"
                                        size="sm"
                                        required
                                        placeholder="Latitude"
                                    />
                                </UFormField>
                                <UFormField
                                    label="Longitude"
                                    :error="$page.props.errors?.longitude"
                                >
                                    <UInput
                                        v-model="formData.longitude"
                                        type="text"
                                        size="sm"
                                        required
                                        placeholder="Longitude"
                                    />
                                </UFormField>
                                <UFormField
                                    label="Ville"
                                    :error="$page.props.errors?.city"
                                >
                                    <UInput
                                        v-model="formData.city"
                                        type="text"
                                        size="sm"
                                        required
                                        placeholder="Ville"
                                    />
                                </UFormField>
                                <UFormField
                                    label="Code Postal"
                                    :error="$page.props.errors?.postal_code"
                                >
                                    <UInput
                                        v-model="formData.postal_code"
                                        type="text"
                                        size="sm"
                                        required
                                        placeholder="Code Postal"
                                    />
                                </UFormField>
                            </div>
                        </template>

                        <template #footer>
                            <div class="flex gap-4">
                                <UButton
                                    label="Suivant"
                                    block
                                    icon="i-lucide-arrow-right"
                                    :disabled="!formData.latitude || !formData.longitude"
                                    @click="$refs.stepper.next()"
                                />
                            </div>
                        </template>
                    </UCard>
                </template>

                <template #details>
                    <UCard>
                        <template #title>
                            Donnez quelques détails
                        </template>

                        <template #default>
                            <UFormField
                                label="Que peut-on y trouver ?"
                                :error="$page.props.errors?.gleanable_id"
                            >
                                <USelectMenu
                                    v-model="formData.gleanable_id"
                                    :items="gleanables"
                                    label-key="name"
                                    value-key="id"
                                    placeholder="Choisir une option"
                                    class="w-full md:w-56"
                                    required
                                />
                            </UFormField>

                            <UFormField
                                class="mt-6"
                                label="Un petit commentaire pour les autres glaneurs ?"
                            >
                                <UTextarea
                                    v-model="formData.description"
                                    placeholder="Décrivez le lieu, comment y accéder, ce que l'on peut y trouver, etc."
                                    class="w-full"
                                />
                            </UFormField>
                        </template>

                        <template #footer>
                            <div class="flex gap-4">
                                <UButton
                                    label="Précédent"
                                    block
                                    color="neutral"
                                    variant="outline"
                                    icon="i-lucide-arrow-left"
                                    @click="$refs.stepper.prev()"
                                />
                                <UButton
                                    label="Suivant"
                                    block
                                    trailing-icon="i-lucide-arrow-right"
                                    :disabled="!formData.gleanable_id"
                                    @click="$refs.stepper.next()"
                                />
                            </div>
                        </template>
                    </UCard>
                </template>

                <template #photos>
                    <UCard>
                        <template #title>
                            Des photos ?
                        </template>

                        <template #default>
                            <UFileUpload
                                v-model="files"
                                accept="image/*"
                                multiple
                                :preview="false"
                                :disabled="uploading"
                                label="Choisir des photos"
                                @update:model-value="onFilesSelected"
                            />

                            <div class="grid mt-6 grid-cols-2 gap-4 md:grid-cols-3">
                                <div
                                    v-for="image in formData.fileUrls"
                                    :key="image"
                                    class="relative flex-col flex items-center"
                                >
                                    <img
                                        :src="image"
                                        alt="decoration"
                                    >
                                    <UButton
                                        icon="i-lucide-x"
                                        color="error"
                                        variant="ghost"
                                        @click="formData.fileUrls = formData.fileUrls.filter((url) => url !== image)"
                                    />
                                </div>
                            </div>
                        </template>

                        <template #footer>
                            <div class="flex gap-4">
                                <UButton
                                    label="Précédent"
                                    block
                                    color="neutral"
                                    variant="outline"
                                    icon="i-lucide-arrow-left"
                                    @click="$refs.stepper.prev()"
                                />
                                <UButton
                                    label="Suivant"
                                    block
                                    trailing-icon="i-lucide-arrow-right"
                                    @click="$refs.stepper.next()"
                                />
                            </div>
                        </template>
                    </UCard>
                </template>

                <template #validation>
                    <UCard>
                        <template #title>
                            Validation
                        </template>

                        <template #default>
                            <UCheckbox
                                v-model="formData.confirmed"
                                name="confirmed"
                                label="Je confirme que les informations sont correctes et que je suis autorisé à les soumettre."
                            />
                            <small
                                v-if="$page.props.errors && $page.props.errors.confirmed"
                                class="text-red-600"
                            >{{ $page.props.errors.confirmed }}</small>

                            <div
                                v-if="$page.props.errors && Object.keys($page.props.errors).length"
                                class="mt-6 rounded-md bg-red-50 p-4 text-sm text-red-800"
                            >
                                <p class="font-semibold">
                                    Veuillez corriger les erreurs suivantes :
                                </p>
                                <ul class="list-disc pl-5 mt-2 space-y-1">
                                    <li
                                        v-for="(msg, key) in $page.props.errors"
                                        :key="key"
                                    >
                                        {{ msg }}
                                    </li>
                                </ul>
                            </div>
                        </template>

                        <template #footer>
                            <div class="flex gap-4">
                                <UButton
                                    label="Précédent"
                                    block
                                    color="neutral"
                                    variant="outline"
                                    icon="i-lucide-arrow-left"
                                    @click="$refs.stepper.prev()"
                                />
                                <UButton
                                    label="Soumettre"
                                    block
                                    trailing-icon="i-lucide-check"
                                    @click="submit"
                                />
                            </div>
                        </template>
                    </UCard>
                </template>
            </UStepper>
        </div>
    </AppLayout>
</template>

<script>
import axios from 'axios'
import AppLayout from '@/Layouts/AppLayout.vue'

export default {
    components: { AppLayout },
    props: ['gleanables'],

    data () {
        return {
            step: 'place',
            steps: [
                { value: 'place', title: 'Lieu', slot: 'place' },
                { value: 'details', title: 'Description', slot: 'details' },
                { value: 'photos', title: 'Photos', slot: 'photos' },
                { value: 'validation', title: 'Validation', slot: 'validation' }
            ],
            formData: {
                latitude: null,
                longitude: null,
                city: null,
                postal_code: null,
                gleanable_id: null,
                description: null,
                confirmed: false,
                fileUrls: []
            },
            files: [],
            uploading: false
        }
    },

    methods: {
        onPositionChange (position) {
            this.formData.latitude = position.latitude
            this.formData.longitude = position.longitude
            this.formData.city = position.city
            this.formData.postal_code = position.postalCode
        },

        // Nuxt UI's file upload only picks files, so the upload PrimeVue's
        // FileUpload used to perform on its own is done here.
        async onFilesSelected (files) {
            if (!files || !files.length) {
                return
            }

            const body = new FormData()
            files.forEach(file => body.append('files[]', file))

            this.uploading = true
            try {
                const { data } = await axios.post('/api/upload', body)
                data.files.forEach(file => this.formData.fileUrls.push(file))
            } finally {
                this.uploading = false
                this.files = []
            }
        },

        submit () {
            this.$inertia.post('/locations', {
                files: this.formData.fileUrls,
                gleanable_id: this.formData.gleanable_id,
                description: this.formData.description,
                latitude: this.formData.latitude,
                longitude: this.formData.longitude,
                city: this.formData.city,
                postal_code: this.formData.postal_code,
                confirmed: this.formData.confirmed
            })
        }
    }
}
</script>
