<template>
    <AppLayout class="bg-slate-50">
        <Head>
            <title>
                Glanage de {{ gleaningLocation.gleanable.name }} à {{ gleaningLocation.postal_code }}
                {{ gleaningLocation.city }}
            </title>
            <meta
                name="description"
                :content="`Glanage de ${gleaningLocation.gleanable.name} à ${gleaningLocation.postal_code} ${gleaningLocation.city}`"
            >
            <link
                rel="canonical"
                :href="route('locations.show', gleaningLocation.id)"
            >
            <meta
                property="og:type"
                content="article"
            >
            <meta
                property="og:title"
                :content="`Glanage de ${gleaningLocation.gleanable.name} - JeGlane.be`"
            >
            <meta
                property="og:description"
                :content="`Glanage de ${gleaningLocation.gleanable.name} à ${gleaningLocation.postal_code} ${gleaningLocation.city}`"
            >
            <meta
                property="og:image"
                :content="(gleaningLocation.files && gleaningLocation.files[0]) ? gleaningLocation.files[0] : '/logo.png'"
            >
            <meta
                property="og:url"
                :content="route('locations.show', gleaningLocation.id)"
            >
            <meta
                name="twitter:card"
                content="summary_large_image"
            >
            <meta
                name="twitter:title"
                :content="`Glanage de ${gleaningLocation.gleanable.name} - JeGlane.be`"
            >
            <meta
                name="twitter:description"
                :content="`Glanage de ${gleaningLocation.gleanable.name} à ${gleaningLocation.postal_code} ${gleaningLocation.city}`"
            >
            <meta
                name="twitter:image"
                :content="(gleaningLocation.files && gleaningLocation.files[0]) ? gleaningLocation.files[0] : '/logo.png'"
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

            <UCarousel
                v-slot="{ item }"
                :items="gleaningLocation.files"
                arrows
                loop
                class="max-w-[640px]"
            >
                <img
                    :src="item"
                    alt="Photo"
                    class="w-full max-h-[400px] object-cover"
                >
            </UCarousel>

            <UCard>
                <template #title>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            Soumis par
                            <span class="ml-1">{{ gleaningLocation.user.name }}</span>
                            <UAvatar
                                :src="gleaningLocation.user.profile_photo_url"
                                class="ml-2"
                            />
                        </div>
                        <div class="flex items-center gap-2">
                            <UButton
                                :disabled="!$page.props.auth.user"
                                :variant="!gleaningLocation.user_vote || gleaningLocation.user_vote.vote !== 1 ? 'outline' : 'solid'"
                                icon="i-lucide-chevron-up"
                                color="success"
                                @click="vote(1)"
                            />
                            <span class="font-bold text-lg">{{ voteCount }}</span>
                            <UButton
                                :disabled="!$page.props.auth.user"
                                :variant="!gleaningLocation.user_vote || gleaningLocation.user_vote.vote !== -1 ? 'outline' : 'solid'"
                                icon="i-lucide-chevron-down"
                                color="error"
                                @click="vote(-1)"
                            />
                        </div>
                    </div>
                </template>
                <template #description>
                    Le {{ $dayjs(gleaningLocation.created_at).format('DD/MM/YYYY') }}
                </template>

                <p class="m-0 overflow-hidden">
                    {{
                        gleaningLocation.description
                            ? gleaningLocation.description
                            : 'Aucune description'
                    }}
                </p>
            </UCard>

            <UCard class="lg:col-span-2">
                <template #title>
                    Commentaires
                </template>

                <template #default>
                    <div
                        v-if="$page.props.auth.user"
                        class="mb-6"
                    >
                        <form @submit.prevent="submitComment">
                            <UTextarea
                                v-model="form.content"
                                placeholder="Laissez un commentaire..."
                                autoresize
                                :rows="3"
                                class="w-full"
                            />
                            <div class="flex justify-end mt-2">
                                <UButton
                                    type="submit"
                                    label="Commenter"
                                    :loading="form.processing"
                                />
                            </div>
                        </form>
                    </div>

                    <div
                        v-else
                        class="mb-6 text-center"
                    >
                        <p class="text-gray-600">
                            Connectez-vous pour laisser un commentaire
                        </p>
                        <Link
                            :href="route('login')"
                            class="text-primary-600"
                        >
                            Se connecter
                        </Link>
                    </div>

                    <div class="space-y-6">
                        <div
                            v-for="comment in gleaningLocation.comments"
                            :key="comment.id"
                        >
                            <div class="flex gap-4">
                                <UAvatar
                                    :src="comment.user.profile_photo_url"
                                />
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <div class="font-medium">
                                            {{ comment.user.name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $dayjs(comment.created_at).format('DD/MM/YYYY HH:mm') }}
                                        </div>
                                    </div>
                                    <p class="mt-1">
                                        {{ comment.content }}
                                    </p>
                                    <div class="mt-2 flex gap-4">
                                        <UButton
                                            v-if="$page.props.auth.user"
                                            variant="ghost"
                                            size="sm"
                                            label="Répondre"
                                            @click="replyTo(comment)"
                                        />
                                        <UButton
                                            v-if="$page.props.auth.user && $page.props.auth.user.id === comment.user_id"
                                            color="error"
                                            variant="ghost"
                                            size="sm"
                                            label="Supprimer"
                                            @click="deleteComment(comment.id)"
                                        />
                                    </div>
                                </div>
                            </div>

                            <!-- Nested replies -->
                            <div
                                v-if="comment.replies && comment.replies.length"
                                class="ml-12 mt-4 space-y-4"
                            >
                                <div
                                    v-for="reply in comment.replies"
                                    :key="reply.id"
                                    class="flex gap-4"
                                >
                                    <UAvatar
                                        :src="reply.user.profile_photo_url"
                                    />
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <div class="font-medium">
                                                {{ reply.user.name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $dayjs(reply.created_at).format('DD/MM/YYYY HH:mm') }}
                                            </div>
                                        </div>
                                        <p class="mt-1">
                                            {{ reply.content }}
                                        </p>
                                        <div
                                            v-if="$page.props.auth.user && $page.props.auth.user.id === reply.user_id"
                                            class="mt-2"
                                        >
                                            <UButton
                                                color="error"
                                                variant="ghost"
                                                size="sm"
                                                label="Supprimer"
                                                @click="deleteComment(reply.id)"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Reply form -->
                            <div
                                v-if="replyingTo === comment.id"
                                class="ml-12 mt-4"
                            >
                                <form @submit.prevent="submitReply(comment.id)">
                                    <UTextarea
                                        v-model="replyForm.content"
                                        :placeholder="'Répondre à ' + comment.user.name"
                                        autoresize
                                        :rows="2"
                                        class="w-full"
                                    />
                                    <div class="flex justify-end gap-2 mt-2">
                                        <UButton
                                            variant="ghost"
                                            size="sm"
                                            label="Annuler"
                                            @click="cancelReply"
                                        />
                                        <UButton
                                            type="submit"
                                            size="sm"
                                            label="Répondre"
                                            :loading="replyForm.processing"
                                        />
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div
                            v-if="!gleaningLocation.comments.length"
                            class="text-center text-gray-500"
                        >
                            Aucun commentaire pour le moment
                        </div>
                    </div>
                </template>
            </UCard>
        </div>
    </AppLayout>
</template>

<script>
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

export default {
    components: { AppLayout },
    props: ['gleaningLocation', 'voteCount'],

    data () {
        return {
            form: useForm({
                content: ''
            }),
            replyForm: useForm({
                content: '',
                parent_id: null
            }),
            replyingTo: null
        }
    },

    computed: {
        jsonLd () {
            const gl = this.gleaningLocation
            const image = (gl.files && gl.files.length > 0) ? gl.files[0] : '/logo.png'
            const ld = {
                '@context': 'https://schema.org',
                '@type': 'Place',
                'name': `Glanage de ${gl.gleanable.name}`,
                'image': image,
                'url': this.route('locations.show', gl.id),
                'address': {
                    '@type': 'PostalAddress',
                    'addressLocality': gl.city,
                    'postalCode': gl.postal_code,
                    'addressCountry': 'BE'
                },
                'geo': {
                    '@type': 'GeoCoordinates',
                    'latitude': gl.latitude,
                    'longitude': gl.longitude
                },
                'description': gl.description || `Glanage de ${gl.gleanable.name} à ${gl.postal_code} ${gl.city}`
            }
            return JSON.stringify(ld)
        }
    },

    created () {
        setTimeout(() => {
            if (this.$refs?.mainMap) {
                this.$refs.mainMap.centerOn(this.gleaningLocation.latitude, this.gleaningLocation.longitude)
            }
        }, 1000)
    },

    methods: {
        vote (value) {
            this.$inertia.post(`/locations/${this.gleaningLocation.id}/vote`, {
                vote: value
            })
        },

        submitComment () {
            this.form.post(route('locations.comments.store', this.gleaningLocation.id), {
                preserveScroll: true,
                onSuccess: () => {
                    this.form.reset()
                }
            })
        },

        replyTo (comment) {
            this.replyingTo = comment.id
            this.replyForm.parent_id = comment.id
        },

        cancelReply () {
            this.replyingTo = null
            this.replyForm.reset()
        },

        submitReply (commentId) {
            this.replyForm.post(route('locations.comments.store', this.gleaningLocation.id), {
                preserveScroll: true,
                onSuccess: () => {
                    this.replyForm.reset()
                    this.replyingTo = null
                }
            })
        },

        deleteComment (commentId) {
            if (confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?')) {
                this.$inertia.delete(route('locations.comments.destroy', [this.gleaningLocation.id, commentId]), {
                    preserveScroll: true
                })
            }
        }
    }
}
</script>
