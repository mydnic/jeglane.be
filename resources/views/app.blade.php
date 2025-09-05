<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" href="/logo.png" type="image/png"/>

        <title inertia>{{ config('app.name', 'Jeglane.be - Votre guide pour le glanage en Belgique') }}</title>

        <!-- SEO Defaults (pages can override via Inertia <Head>) -->
        <link rel="canonical" href="{{ url()->current() }}">
        <meta name="description" content="Jeglane.be recense les lieux de glanage en Belgique. Explorez la carte, partagez vos découvertes et trouvez des produits frais près de chez vous." />
        <meta name="robots" content="index,follow" />
        <meta name="theme-color" content="#059669" />

        <!-- Open Graph Defaults -->
        <meta property="og:site_name" content="{{ config('app.name', 'Jeglane.be') }}" />
        <meta property="og:locale" content="fr_BE" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="{{ config('app.name', 'Jeglane.be') }}" />
        <meta property="og:description" content="Jeglane.be recense les lieux de glanage en Belgique. Explorez la carte, partagez vos découvertes et trouvez des produits frais près de chez vous." />
        <meta property="og:image" content="{{ asset('logo.png') }}" />
        <meta property="og:url" content="{{ url()->current() }}" />

        <!-- Twitter Card Defaults -->
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="{{ config('app.name', 'Jeglane.be') }}" />
        <meta name="twitter:description" content="Jeglane.be recense les lieux de glanage en Belgique. Explorez la carte, partagez vos découvertes et trouvez des produits frais près de chez vous." />
        <meta name="twitter:image" content="{{ asset('logo.png') }}" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js'])
        @inertiaHead
        @voletStyles
        <style>
            :root {
                --volet-primary: #059669;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        @inertia
        @volet
    </body>
</html>
