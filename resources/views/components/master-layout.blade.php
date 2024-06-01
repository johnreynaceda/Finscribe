<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @wireUiScripts
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    @filamentStyles
    @vite('resources/css/app.css')
</head>

<body class="font-sans antialiased">

    <div class="flex h-screen overflow-hidden bg-gray-200">
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64">
                <div class="flex flex-col flex-grow pt-5 overflow-y-auto bg-main ">
                    <div class="flex flex-col flex-shrink-0 px-4">
                        {{-- <a class="text-lg font-semibold tracking-tighter text-white focus:outline-none focus:ring"
                            href="/">
                            <span class="inline-flex items-center gap-2">
                                <img src="{{ asset('images/logo.jpg') }}" class="h-8" alt="">
                                FinScribe
                            </span>
                        </a> --}}
                        <button class="hidden rounded-lg focus:outline-none focus:shadow-outline">
                            <svg fill="currentColor" viewBox="0 0 20 20" class="size-6">
                                <path fill-rule="evenodd"
                                    d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z"
                                    clip-rule="evenodd"></path>
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="flex flex-col flex-grow px-4 ">
                        <center>
                            <img src="{{ asset('images/business_logo.png') }}" class="h-20" alt="">
                            <span class="mt-2 text-white uppercase">{{ auth()->user()->name }}</span>
                            <h1 class="text-xs text-gray-400">({{ auth()->user()->user_type }})</h1>
                        </center>
                        <livewire:sidebar />
                    </div>

                </div>
            </div>
        </div>
        <div class="flex flex-col relative flex-1 w-0 overflow-hidden">
            <livewire:navbar />
            <main class="relative flex-1 overflow-y-auto focus:outline-none">
                <div class="py-6 px-3 2xl:px-0">
                    <div class="mx-auto py-5 2xl:max-w-7xl">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </div>
    @filamentScripts
    @vite('resources/js/app.js')
</body>

</html>
