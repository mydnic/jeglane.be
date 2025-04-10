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
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            Soumis par
                            <span class="ml-1">{{ gleaningLocation.user.name }}</span>
                            <Avatar
                                :image="gleaningLocation.user.profile_photo_url"
                                shape="circle"
                                class="ml-2"
                            />
                        </div>
                        <div class="flex items-center gap-2">
                            <Button
                                :disabled="!$page.props.auth.user"
                                :outlined="!gleaningLocation.user_vote || gleaningLocation.user_vote.vote !== 1"
                                icon="pi pi-chevron-up"
                                severity="success"
                                @click="vote(1)"
                            />
                            <span class="font-bold text-lg">{{ voteCount }}</span>
                            <Button
                                :disabled="!$page.props.auth.user"
                                :outlined="!gleaningLocation.user_vote || gleaningLocation.user_vote.vote !== -1"
                                icon="pi pi-chevron-down"
                                severity="danger"
                                @click="vote(-1)"
                            />
                        </div>
                    </div>
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

            <Card class="lg:col-span-2">
                <template #title>
                    Commentaires
                </template>

                <template #content>
                    <div v-if="$page.props.auth.user" class="mb-6">
                        <form @submit.prevent="submitComment">
                            <Textarea
                                v-model="form.content"
                                placeholder="Laissez un commentaire..."
                                :autoResize="true"
                                rows="3"
                                class="w-full"
                            />
                            <div class="flex justify-end mt-2">
                                <Button
                                    type="submit"
                                    label="Commenter"
                                    :loading="form.processing"
                                />
                            </div>
                        </form>
                    </div>

                    <div v-else class="mb-6 text-center">
                        <p class="text-gray-600">Connectez-vous pour laisser un commentaire</p>
                        <Link :href="route('login')" class="text-primary-600">Se connecter</Link>
                    </div>

                    <div class="space-y-6">
                        <div v-for="comment in gleaningLocation.comments" :key="comment.id">
                            <div class="flex gap-4">
                                <Avatar
                                    :image="comment.user.profile_photo_url"
                                    shape="circle"
                                />
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <div class="font-medium">{{ comment.user.name }}</div>
                                        <div class="text-sm text-gray-500">
                                            {{ $dayjs(comment.created_at).format('DD/MM/YYYY HH:mm') }}
                                        </div>
                                    </div>
                                    <p class="mt-1">{{ comment.content }}</p>
                                    <div class="mt-2 flex gap-4">
                                        <Button
                                            v-if="$page.props.auth.user"
                                            text
                                            size="small"
                                            label="Répondre"
                                            @click="replyTo(comment)"
                                        />
                                        <Button
                                            v-if="$page.props.auth.user && $page.props.auth.user.id === comment.user_id"
                                            severity="danger"
                                            text
                                            size="small"
                                            label="Supprimer"
                                            @click="deleteComment(comment.id)"
                                        />
                                    </div>
                                </div>
                            </div>

                            <!-- Nested replies -->
                            <div v-if="comment.replies && comment.replies.length" class="ml-12 mt-4 space-y-4">
                                <div v-for="reply in comment.replies" :key="reply.id" class="flex gap-4">
                                    <Avatar
                                        :image="reply.user.profile_photo_url"
                                        shape="circle"
                                    />
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <div class="font-medium">{{ reply.user.name }}</div>
                                            <div class="text-sm text-gray-500">
                                                {{ $dayjs(reply.created_at).format('DD/MM/YYYY HH:mm') }}
                                            </div>
                                        </div>
                                        <p class="mt-1">{{ reply.content }}</p>
                                        <div v-if="$page.props.auth.user && $page.props.auth.user.id === reply.user_id" class="mt-2">
                                            <Button
                                                severity="danger"
                                                text
                                                size="small"
                                                label="Supprimer"
                                                @click="deleteComment(reply.id)"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Reply form -->
                            <div v-if="replyingTo === comment.id" class="ml-12 mt-4">
                                <form @submit.prevent="submitReply(comment.id)">
                                    <Textarea
                                        v-model="replyForm.content"
                                        :placeholder="'Répondre à ' + comment.user.name"
                                        :autoResize="true"
                                        rows="2"
                                        class="w-full"
                                    />
                                    <div class="flex justify-end gap-2 mt-2">
                                        <Button
                                            text
                                            size="small"
                                            label="Annuler"
                                            @click="cancelReply"
                                        />
                                        <Button
                                            type="submit"
                                            size="small"
                                            label="Répondre"
                                            :loading="replyForm.processing"
                                        />
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div v-if="!gleaningLocation.comments.length" class="text-center text-gray-500">
                            Aucun commentaire pour le moment
                        </div>
                    </div>
                </template>
            </Card>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm } from '@inertiajs/vue3'

export default {
    components: { AppLayout },
    props: ['gleaningLocation', 'voteCount'],

    data() {
        return {
            form: useForm({
                content: '',
            }),
            replyForm: useForm({
                content: '',
                parent_id: null,
            }),
            replyingTo: null,
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

        submitComment() {
            this.form.post(route('locations.comments.store', this.gleaningLocation.id), {
                preserveScroll: true,
                onSuccess: () => {
                    this.form.reset()
                },
            })
        },

        replyTo(comment) {
            this.replyingTo = comment.id
            this.replyForm.parent_id = comment.id
        },

        cancelReply() {
            this.replyingTo = null
            this.replyForm.reset()
        },

        submitReply(commentId) {
            this.replyForm.post(route('locations.comments.store', this.gleaningLocation.id), {
                preserveScroll: true,
                onSuccess: () => {
                    this.replyForm.reset()
                    this.replyingTo = null
                },
            })
        },

        deleteComment(commentId) {
            if (confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?')) {
                this.$inertia.delete(route('locations.comments.destroy', [this.gleaningLocation.id, commentId]), {
                    preserveScroll: true,
                })
            }
        },
    }
}
</script>
