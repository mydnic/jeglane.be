<script setup>
import { Head } from '@inertiajs/vue3'
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue'
import AppLayout from '@/Layouts/AppLayout.vue'

defineProps({
    about: String
})
</script>

<template>
    <Head title="À propos" />

    <AppLayout>
        <div class="bg-white px-6 py-24 sm:py-32 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-5xl font-semibold tracking-tight text-gray-900 sm:text-7xl capitalize mb-6">
                    à propos
                </h2>

                <div class="prose text-base/7 text-gray-700">
                    <p>
                        Salut ! Moi, c’est Clément, et je suis à l’origine de Jeglane.be. Si j’ai décidé de lancer ce site, c’est parce que, comme beaucoup, je me suis souvent demandé : "C'est quand encore la période de glanage des pommes de terre ? Oh et, Où est-ce que je peux aller glaner, en fait?". Trouver des infos claires et précises, c’était un vrai casse-tête. Alors, plutôt que de garder ça compliqué, j’ai voulu simplifier les choses et créer un endroit où tout le monde pourrait partager ses bons plans de glanage.
                    </p>

                    <h3>L’idée ?</h3>
                    <p>
                        Faire de Jeglane.be une plateforme communautaire où chacun peut contribuer : ajouter des lieux,
                        poster des photos, et discuter avec d’autres glaneurs passionnés. Plus on partage, plus on
                        s’entraide, et mieux c’est pour tout le monde.
                    </p>

                    <h3>Pourquoi ce site ?</h3>
                    <p>
                        Mon objectif, c’est d’aider les gens comme moi qui galèrent à trouver des lieux de glanage en
                        Belgique. En plus, ça permet de réduire le gaspillage alimentaire, de consommer différemment,
                        et, soyons honnêtes, de profiter de bons produits frais… gratuitement !
                    </p>

                    <h3>Open source, gratuit et sans pub</h3>
                    <p>
                        Une chose à laquelle je tiens beaucoup : Jeglane.be est 100 % gratuit et sans publicité. Je
                        voulais que tout le monde puisse accéder aux infos sans être pollué par des pubs ou des frais
                        cachés.
                    </p>

                    <p>
                        Et ce n’est pas tout : le site est open source. Ça veut dire que si vous avez des compétences en
                        développement ou des idées d’améliorations, vous pouvez aussi contribuer à faire évoluer
                        Jeglane.be. Que ce soit en partageant du code, en proposant des nouvelles fonctionnalités ou
                        simplement en rapportant des bugs, toutes les contributions sont les bienvenues.
                    </p>

                    <h3>Un peu de philosophie</h3>
                    <p>
                        Je suis fan de Tolkien, et ses histoires m’inspirent souvent. Voici une citation qui, je trouve,
                        colle bien à l’esprit du site :
                    </p>
                    <p>
                        "All we have to decide is what to do with the time that is given us." ("Tout ce que nous avons à
                        décider, c'est quoi faire du temps qui nous est imparti.")
                    </p>
                    <p>
                        Pour moi, c’est un rappel qu’on peut tous agir, à notre échelle, pour créer des choses
                        positives. Jeglane.be, c’est ma façon de faire un petit pas dans ce sens.
                    </p>
                </div>
            </div>
            <div class="bg-white py-16 sm:py-24">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="relative overflow-hidden bg-gray-900 px-6 py-20 shadow-xl sm:rounded-3xl sm:px-10 sm:py-24 md:px-12 lg:px-20">
                        <img
                            class="absolute inset-0 size-full object-cover brightness-150 saturate-0"
                            src="https://images.unsplash.com/photo-1601381718415-a05fb0a261f3?ixid=MXwxMjA3fDB8MHxwcm9maWxlLXBhZ2V8ODl8fHxlbnwwfHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1216&q=80"
                            alt=""
                        >
                        <div class="absolute inset-0 bg-gray-900/90 mix-blend-multiply" />
                        <div
                            class="absolute -left-80 -top-56 transform-gpu blur-3xl"
                            aria-hidden="true"
                        >
                            <div
                                class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-r from-[#ff4694] to-[#776fff] opacity-[0.45]"
                                style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"
                            />
                        </div>
                        <div
                            class="hidden md:absolute md:bottom-16 md:left-[50rem] md:block md:transform-gpu md:blur-3xl"
                            aria-hidden="true"
                        >
                            <div
                                class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-r from-[#ff4694] to-[#776fff] opacity-25"
                                style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"
                            />
                        </div>
                        <div class="relative mx-auto max-w-2xl lg:mx-0">
                            <figure>
                                <blockquote class="mt-6 text-lg font-semibold text-white sm:text-xl/8">
                                    <p>"Les arbres, l'herbe et toutes les choses qui poussent ou vivent sur la terre appartiennent à elles-mêmes."</p>
                                </blockquote>
                                <figcaption class="mt-6 text-base text-white">
                                    <div class="font-semibold">
                                        JRR Tolkien
                                    </div>
                                </figcaption>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
