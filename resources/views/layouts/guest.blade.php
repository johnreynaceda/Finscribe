<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" href="{{ asset('images/business_logo.png') }}" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @wireUiScripts
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    @filamentStyles
    @vite('resources/css/app.css')
</head>

<body class="font-sans text-gray-900 antialiased">
    <x-dialog z-index="z-50" blur="md" align="center" />
    <div class="fixed hidden  right-0 w-96 bottom-0 top-0 z-10  bg-[#1A2634] 2xl:grid place-content-center">
        <img src="{{ asset('images/logo.jpg') }}" alt="">
    </div>
    <div class="fixed hidden left-0 w-96 bottom-0 top-0 z-10  bg-[#1A2634] 2xl:grid place-content-center">
        <img src="{{ asset('images/logo.jpg') }}" alt="">
    </div>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 px-5 sm:pt-0 bg-white">
        <div class="text-center">

            @yield('content')
        </div>

        <div class="w-full sm:max-w-md mt-6   py-4 bg-white   sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
    <div class="fixed left-0 bottom-10 w-full right-0 text-center">
        © 2023 All Rights Reserved. FinScribe
    </div>
    @filamentScripts
    @vite('resources/js/app.js')
</body>

</html>
