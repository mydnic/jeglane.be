<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import AuthenticationCard from '@/Components/AuthenticationCard.vue'
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue'
import Checkbox from '@/Components/Checkbox.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import AppLayout from '@/Layouts/AppLayout.vue'

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false
})

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation')
    })
}
</script>

<template>
    <Head title="Register" />
    <AppLayout>
        <section class="bg-gray-50 py-10">
            <div class="max-w-screen-xl px-4 py-8 mx-auto lg:grid lg:gap-20 lg:py-16 lg:grid-cols-12">
                <div class="flex-col justify-between hidden mr-auto lg:flex lg:col-span-5 xl:col-span-6 xl:mb-0">
                    <div>
                        <AuthenticationCardLogo />

                        <h2 class="text-base mt-10 font-semibold leading-7 text-emerald-600">
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
                <div class="mb-6 text-center lg:hidden">
                    <a
                        href="#"
                        class="inline-flex items-center text-2xl font-semibold text-gray-900 lg:hidden"
                    >
                        <img
                            class="w-8 h-8 mr-2"
                            src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo.svg"
                            alt="logo"
                        >
                        Flowbite
                    </a>
                </div>
                <div class="w-full mx-auto bg-white rounded-lg shadow md:mt-0 sm:max-w-lg xl:p-0 lg:col-span-7 xl:col-span-6">
                    <div class="p-6 space-y-4 lg:space-y-6 sm:p-8">
                        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 sm:text-2xl">
                            Créer un compte
                        </h1>
                        <div class="items-center space-y-3 sm:space-x-4 sm:space-y-0 sm:flex">
                            <a
                                href="#"
                                class="w-full inline-flex items-center justify-center py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-gray-900 focus:z-10 focus:ring-4 focus:ring-gray-200"
                            >
                                <svg
                                    class="w-5 h-5 mr-2"
                                    viewBox="0 0 21 20"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <g clip-path="url(#clip0_13183_10121)"><path
                                        d="M20.3081 10.2303C20.3081 9.55056 20.253 8.86711 20.1354 8.19836H10.7031V12.0492H16.1046C15.8804 13.2911 15.1602 14.3898 14.1057 15.0879V17.5866H17.3282C19.2205 15.8449 20.3081 13.2728 20.3081 10.2303Z"
                                        fill="#3F83F8"
                                    /><path
                                        d="M10.7019 20.0006C13.3989 20.0006 15.6734 19.1151 17.3306 17.5865L14.1081 15.0879C13.2115 15.6979 12.0541 16.0433 10.7056 16.0433C8.09669 16.0433 5.88468 14.2832 5.091 11.9169H1.76562V14.4927C3.46322 17.8695 6.92087 20.0006 10.7019 20.0006V20.0006Z"
                                        fill="#34A853"
                                    /><path
                                        d="M5.08857 11.9169C4.66969 10.6749 4.66969 9.33008 5.08857 8.08811V5.51233H1.76688C0.348541 8.33798 0.348541 11.667 1.76688 14.4927L5.08857 11.9169V11.9169Z"
                                        fill="#FBBC04"
                                    /><path
                                        d="M10.7019 3.95805C12.1276 3.936 13.5055 4.47247 14.538 5.45722L17.393 2.60218C15.5852 0.904587 13.1858 -0.0287217 10.7019 0.000673888C6.92087 0.000673888 3.46322 2.13185 1.76562 5.51234L5.08732 8.08813C5.87733 5.71811 8.09302 3.95805 10.7019 3.95805V3.95805Z"
                                        fill="#EA4335"
                                    /></g><defs><clipPath id="clip0_13183_10121"><rect
                                        width="20"
                                        height="20"
                                        fill="white"
                                        transform="translate(0.5)"
                                    /></clipPath></defs>
                                </svg>
                                Sign up with Google
                            </a>
                            <a
                                href="#"
                                class="w-full inline-flex items-center justify-center py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-gray-900 focus:z-10 focus:ring-4 focus:ring-gray-200"
                            >
                                <svg
                                    class="w-5 h-5 mr-2 text-gray-900"
                                    viewBox="0 0 21 20"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <g clip-path="url(#clip0_13183_29163)"><path
                                        d="M18.6574 15.5863C18.3549 16.2851 17.9969 16.9283 17.5821 17.5196C17.0167 18.3257 16.5537 18.8838 16.1969 19.1936C15.6439 19.7022 15.0513 19.9627 14.4168 19.9775C13.9612 19.9775 13.4119 19.8479 12.7724 19.585C12.1308 19.3232 11.5412 19.1936 11.0021 19.1936C10.4366 19.1936 9.83024 19.3232 9.18162 19.585C8.53201 19.8479 8.00869 19.985 7.60858 19.9985C7.00008 20.0245 6.39356 19.7566 5.78814 19.1936C5.40174 18.8566 4.91842 18.2788 4.33942 17.4603C3.71821 16.5863 3.20749 15.5727 2.80738 14.4172C2.37887 13.1691 2.16406 11.9605 2.16406 10.7904C2.16406 9.45009 2.45368 8.29407 3.03379 7.32534C3.4897 6.54721 4.09622 5.9334 4.85533 5.4828C5.61445 5.03219 6.43467 4.80257 7.31797 4.78788C7.80129 4.78788 8.4351 4.93738 9.22273 5.2312C10.0081 5.52601 10.5124 5.67551 10.7335 5.67551C10.8988 5.67551 11.4591 5.5007 12.4088 5.15219C13.3069 4.82899 14.0649 4.69517 14.6859 4.74788C16.3685 4.88368 17.6327 5.54699 18.4734 6.74202C16.9685 7.65384 16.2241 8.93097 16.2389 10.5693C16.2525 11.8454 16.7154 12.9074 17.6253 13.7506C18.0376 14.1419 18.4981 14.4444 19.0104 14.6592C18.8993 14.9814 18.7821 15.29 18.6574 15.5863V15.5863ZM14.7982 0.400358C14.7982 1.40059 14.4328 2.3345 13.7044 3.19892C12.8254 4.22654 11.7623 4.82035 10.6093 4.72665C10.5947 4.60665 10.5861 4.48036 10.5861 4.34765C10.5861 3.38743 11.0041 2.3598 11.7465 1.51958C12.1171 1.09416 12.5884 0.740434 13.16 0.458257C13.7304 0.18029 14.2698 0.0265683 14.7772 0.000244141C14.7921 0.133959 14.7982 0.267682 14.7982 0.400345V0.400358Z"
                                        fill="currentColor"
                                    /></g><defs><clipPath id="clip0_13183_29163"><rect
                                        width="20"
                                        height="20"
                                        fill="white"
                                        transform="translate(0.5)"
                                    /></clipPath></defs>
                                </svg>
                                Sign up with Apple
                            </a>
                        </div>
                        <div class="flex items-center">
                            <div class="w-full h-0.5 bg-gray-200" />
                            <div class="px-5 text-center text-gray-500">
                                ou
                            </div>
                            <div class="w-full h-0.5 bg-gray-200" />
                        </div>
                        <form
                            class="space-y-4 lg:space-y-6"
                            @submit.prevent="submit"
                        >
                            <div>
                                <InputLabel
                                    for="name"
                                    value="Nom"
                                />
                                <TextInput
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                    autofocus
                                    autocomplete="name"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.name"
                                />
                            </div>
                            <div class="mt-4">
                                <InputLabel
                                    for="email"
                                    value="Email"
                                />
                                <TextInput
                                    id="email"
                                    v-model="form.email"
                                    type="email"
                                    class="mt-1 block w-full"
                                    required
                                    autocomplete="username"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.email"
                                />
                            </div>
                            <div class="mt-4">
                                <InputLabel
                                    for="password"
                                    value="Mot de passe"
                                />
                                <TextInput
                                    id="password"
                                    v-model="form.password"
                                    type="password"
                                    class="mt-1 block w-full"
                                    required
                                    autocomplete="new-password"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.password"
                                />
                            </div>

                            <div class="mt-4">
                                <InputLabel
                                    for="password_confirmation"
                                    value="Confirmer le mot de passe"
                                />
                                <TextInput
                                    id="password_confirmation"
                                    v-model="form.password_confirmation"
                                    type="password"
                                    class="mt-1 block w-full"
                                    required
                                    autocomplete="new-password"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.password_confirmation"
                                />
                            </div>
                            <div
                                class="mt-4"
                            >
                                <InputLabel for="terms">
                                    <div class="flex items-center">
                                        <Checkbox
                                            id="terms"
                                            v-model:checked="form.terms"
                                            name="terms"
                                            required
                                        />

                                        <div class="ms-2">
                                            J'accepte les <a
                                                target="_blank"
                                                :href="route('terms.show')"
                                                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                            >conditions d'utilisation</a> et la<a
                                                target="_blank"
                                                :href="route('policy.show')"
                                                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                            >politique sur la vie privée</a>
                                        </div>
                                    </div>
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.terms"
                                    />
                                </InputLabel>
                            </div>
                            <Button
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                                type="submit"
                            >
                                Créer mon compte
                            </Button>

                            <p class="text-sm font-light text-gray-500">
                                Vous avez déjà un compte? <Link
                                    :href="route('login')"
                                    class="font-medium text-primary-600 underline"
                                >
                                    Connectez-vous
                                </Link>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>
