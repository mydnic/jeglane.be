<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" href="/logo.png" type="image/png"/>

        <title inertia>{{ config('app.name', 'Jeglane.be - Votre guide pour le glanage en Belgique') }}</title>

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
