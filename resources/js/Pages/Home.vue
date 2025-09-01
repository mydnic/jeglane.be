<template>
    <Head title="Trouver des lieux de glanage en Belgique" />

    <AppLayout>
        <div class="relative isolate overflow-hidden bg-gradient-to-b from-emerald-100/20 pt-14">
            <div
                class="absolute inset-y-0 right-1/2 -z-10 -mr-96 w-[200%] origin-top-right skew-x-[-30deg] bg-white shadow-xl shadow-emerald-600/10 ring-1 ring-emerald-50 sm:-mr-80 lg:-mr-96"
                aria-hidden="true"
            />
            <div class="mx-auto max-w-7xl px-6 py-32 sm:py-40 lg:px-8">
                <div class="mx-auto max-w-2xl lg:mx-0 lg:grid lg:max-w-none lg:grid-cols-2 lg:gap-x-16 lg:gap-y-6 xl:grid-cols-1 xl:grid-rows-1 xl:gap-x-8">
                    <h1 class="max-w-2xl text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl lg:col-span-2 xl:col-auto">
                        Glaner en Belgique n'a jamais été aussi simple !
                    </h1>
                    <div class="mt-6 max-w-xl lg:mt-0 xl:col-end-1 xl:row-start-1">
                        <p class="text-lg leading-8 text-gray-600">
                            Parcourez la carte interactive des champs ouverts au glanage, partagez vos découvertes avec d'autres glaneurs et trouvez des produits frais près de chez vous.
                        </p>
                        <div class="mt-10 flex items-center gap-x-6">
                            <Link
                                href="/locations"
                                class="rounded-md bg-emerald-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600"
                            >
                                Voir la carte
                            </Link>
                            <Link
                                href="/register"
                                class="text-sm font-semibold leading-6 text-gray-900"
                            >
                                S'inscrire
                            </Link>
                        </div>
                    </div>
                    <img
                        src="https://images.unsplash.com/photo-1604300721398-3f58fdf81780?q=80&w=2333&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt=""
                        class="mt-10 aspect-[6/5] w-full max-w-lg rounded-2xl object-cover sm:mt-16 lg:mt-0 lg:max-w-none xl:row-span-2 xl:row-end-2 xl:mt-36"
                    >
                </div>
            </div>
            <div class="absolute inset-x-0 bottom-0 -z-10 h-24 bg-gradient-to-t from-white sm:h-32" />
        </div>

        <div class="bg-white pb-24 sm:pb-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
                    <p class="text-base font-semibold leading-7 text-emerald-600">
                        Explorez. Partagez. Récoltez.
                    </p>
                    <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        Qu'est-ce que le glanage ?
                    </h1>
                    <div class="mt-10 grid max-w-xl grid-cols-1 gap-8 text-base leading-7 text-gray-700 lg:max-w-none lg:grid-cols-2">
                        <div>
                            <p>Le glanage est une pratique ancestrale qui consiste à récolter des légumes, fruits et autres produits qui restent dans les champs après la récolte principale. C’est une manière de réduire le gaspillage alimentaire tout en profitant de produits frais et locaux.</p>
                            <p class="font-semibold">
                                Il est cependant important d'avoir l'accord de l'agriculteur !
                            </p>
                        </div>
                        <div>
                            <p>Sur Jeglane.be, vous pouvez explorer une carte interactive des champs ouverts au glanage, partager vos découvertes avec d'autres glaneurs et trouver des produits frais près de chez vous.</p>
                            <p>Vous pouvez également ajouter des lieux de glanage, envoyer des photos, vérifier les soumissions, etc.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white px-6 py-32 lg:px-8 ">
            <div class="mx-auto max-w-7xl px-6 text-base/7 text-gray-700 ">
                <p class="text-base/7 font-semibold text-emerald-600 ">
                    Un site super simple à utiliser
                </p>
                <h1 class="mt-2 text-4xl font-semibold tracking-tight text-pretty text-gray-900 sm:text-5xl ">
                    Comment ça marche ?
                </h1>
                <p class="mt-6 text-xl/8">
                    JeGlane.be recense les lieux de glanage en Belgique. Ouvrez la carte interactive pour découvrir les points de glanage, leur adresse et toutes les informations utiles.
                </p>

                <div class="mt-10 text-gray-600 space-y-4">
                    <p>Pour ajouter un lieu sur la carte, vous devez créer un compte. Cela nous permet de vérifier les informations et d’éviter les abus (spam, fausses annonces, etc.).</p>
                    <p>Un compte est aussi requis pour participer à la communauté : envoyer des photos, commenter, voter, etc.</p>
                    <p>
                        Chaque lieu publié reste visible sur la carte pendant <strong>2
                            mois</strong>.
                    </p>
                    <p>La consultation de la carte est libre. Un compte est seulement nécessaire pour proposer des lieux, ajouter des photos, etc.</p>
                    <p>La plateforme repose entièrement sur les contributions des utilisateurs : la carte affiche uniquement les lieux soumis par la communauté.</p>
                </div>
            </div>
        </div>

        <div class="overflow-hidden bg-white py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 sm:gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-2">
                    <div class="lg:pr-8 lg:pt-4">
                        <div class="lg:max-w-lg">
                            <h2 class="text-base font-semibold leading-7 text-emerald-600">
                                Quelques règles à respecter
                            </h2>
                            <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                                Avant de commencer
                            </p>
                            <p class="mt-6 text-lg leading-8 text-gray-600">
                                Pour bien glaner, il est important de respecter quelques règles de base. Voici quelques conseils pour glaner en toute sécurité et dans le respect de l'environnement.
                            </p>
                            <dl class="mt-10 max-w-xl space-y-8 text-base leading-7 text-gray-600 lg:max-w-none">
                                <div class="relative pl-9">
                                    <dt class="inline font-semibold text-gray-900">
                                        <CalendarIconSolid class="absolute left-1 top-1 h-5 w-5 text-emerald-600" />
                                    </dt>
                                    <dd class="inline">
                                        Le glanage se déroule toujours après que la récolte soit totalement achevée, en l’absence de travail ou de machine agricole sur la parcelle, et avant le semis suivant
                                    </dd>
                                </div>
                                <div class="relative pl-9">
                                    <dt class="inline font-semibold text-gray-900">
                                        <i class="pi pi-ban absolute left-1 top-1 h-5 w-5 text-emerald-600" />
                                    </dt>
                                    <dd class="inline">
                                        Le glanage ne peut en aucun cas se faire sur des parcelles clôturées
                                    </dd>
                                </div>
                                <div class="relative pl-9">
                                    <dt class="inline font-semibold text-gray-900">
                                        <HandRaisedIconSolid class="absolute left-1 top-1 h-5 w-5 text-emerald-600" />
                                    </dt>
                                    <dd class="inline">
                                        Le glanage ou la cueillette se font à la main (sans matériel lourd)
                                    </dd>
                                </div>
                                <div class="relative pl-9">
                                    <dt class="inline font-semibold text-gray-900">
                                        <svg
                                            class="absolute left-1 top-1 h-5 w-5 text-emerald-600"
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="32"
                                            height="32"
                                            viewBox="0 0 24 24"
                                        ><path
                                            fill="currentColor"
                                            d="M6 19v1q0 .425-.288.713T5 21H4q-.425 0-.712-.288T3 20v-8l2.1-6q.15-.45.538-.725T6.5 5h11q.475 0 .863.275T18.9 6l2.1 6v8q0 .425-.287.713T20 21h-1q-.425 0-.712-.288T18 20v-1zm-.2-9h12.4l-1.05-3H6.85zm1.7 6q.625 0 1.063-.437T9 14.5t-.437-1.062T7.5 13t-1.062.438T6 14.5t.438 1.063T7.5 16m9 0q.625 0 1.063-.437T18 14.5t-.437-1.062T16.5 13t-1.062.438T15 14.5t.438 1.063T16.5 16"
                                        /></svg>
                                    </dt>
                                    <dd class="inline">
                                        Il est toujours demandé aux glaneurs ou cueilleurs de ne pas garer leur véhicule sur le champ, de ne pas entraver la circulation locale et des véhicules agricoles ainsi que de respecter les environs
                                    </dd>
                                </div>
                                <div class="relative pl-9">
                                    <dt class="inline font-semibold text-gray-900">
                                        <ShoppingCartIconSolid class="absolute left-1 top-1 h-5 w-5 text-emerald-600" />
                                    </dt>
                                    <dd class="inline">
                                        Les quantités glanées doivent rester raisonnables et ne pas dépasser l’usage familial normal. En aucun cas, le glanage ne peut se faire dans un but commercial
                                    </dd>
                                </div>
                                <div class="relative pl-9">
                                    <dt class="inline font-semibold text-gray-900">
                                        <HandThumbUpIconSolid class="absolute left-1 top-1 h-5 w-5 text-emerald-600" />
                                    </dt>
                                    <dd class="inline">
                                        L'accord de l'agriculteur n'est pas légalement nécessaire mais il est toujours apprécié de lui en demander l'autorisation lorsque cela est faisable, par courtoisie
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                    <img
                        src="/assets/hands-harvest-corn-in-autumn.jpg"
                        alt="Glanage"
                        class="w-[48rem] max-w-none rounded-xl shadow-xl ring-1 ring-gray-400/10 sm:w-[57rem] md:-ml-4 lg:-ml-0"
                        width="2432"
                        height="1442"
                    >
                </div>
            </div>
        </div>

        <div class="bg-white">
            <div class="mx-auto max-w-7xl py-24 sm:px-6 sm:py-32 lg:px-8">
                <div class="relative isolate overflow-hidden bg-gray-900 px-6 py-24 text-center shadow-2xl sm:rounded-3xl sm:px-16">
                    <h2 class="mx-auto max-w-2xl text-3xl font-bold tracking-tight text-white sm:text-4xl">
                        Rejoignez la communauté !
                    </h2>
                    <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-gray-300">
                        Inscrivez-vous dès maintenant pour accéder à toutes les fonctionnalités de Jeglane.be : créez votre profil, ajoutez des lieux de glanage, envoyez des photos, vérifiez les soumissions, et bien plus encore.
                    </p>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <a
                            :href="route('locations.index')"
                            class="rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-gray-900 shadow-sm hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
                        >Commencez à Glaner !</a>
                        <a
                            :href="route('register')"
                            class="text-sm font-semibold leading-6 text-white"
                        >Inscrivez-vous Gratuitement</a>
                    </div>
                    <svg
                        viewBox="0 0 1024 1024"
                        class="absolute left-1/2 top-1/2 -z-10 h-[64rem] w-[64rem] -translate-x-1/2 [mask-image:radial-gradient(closest-side,white,transparent)]"
                        aria-hidden="true"
                    >
                        <circle
                            cx="512"
                            cy="512"
                            r="512"
                            fill="url(#827591b1-ce8c-4110-b064-7cb85a0b1217)"
                            fill-opacity="0.7"
                        />
                        <defs>
                            <radialGradient id="827591b1-ce8c-4110-b064-7cb85a0b1217">
                                <stop stop-color="#7775D6" />
                                <stop
                                    offset="1"
                                    stop-color="#10b981"
                                />
                            </radialGradient>
                        </defs>
                    </svg>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

export default {
    name: 'Home',
    components: { Head, AppLayout }
}
</script>
