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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">

    <section class="relative overflow-hidden bg-white z-20">
        <div class="relative w-full mx-auto max-w-7xl">

            <div class="relative flex flex-col w-full p-5 mx-auto lg:px-16 md:flex-row md:items-center md:justify-between md:px-6"
                x-data="{ open: false }">
                <div class="flex flex-row items-center justify-between text-sm text-black lg:justify-start">
                    <a href="/">
                        <img src="{{ asset('images/logo.jpg') }}" class="h-14 w-14 object-cover rounded-full"
                            alt="">
                    </a>
                    {{-- <button @click="open = !open"
                        class="items-center justify-center focus:outline-none inline-flex focus:text-black hover:text-[#0000ff] md:hidden p-2 text-black">
                        <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M4 6h16M4 12h16M4 18h16" :class="{ 'hidden': open, 'inline-flex': !open }"
                                class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                            </path>
                            <path d="M6 18L18 6M6 6l12 12" :class="{ 'hidden': !open, 'inline-flex': open }"
                                class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                    </button> --}}
                    <div class="md:hidden p-2 ">
                        <a href="{{ route('login') }}"
                            class="font-medium text-sm active:bg-fuchsia-50 active:text-black bg-indigo-50 focus-visible:outline-2 cursor-pointer focus-visible:outline-fuchsia-50 focus-visible:outline-offset-2 focus:outline-none group hover:bg-[#0000ff]/5 hover:text-[#2F7A83] justify-center px-6 py-2.5 rounded-xl text-gray-600">Sign
                            In</a>
                    </div>
                </div>
                <nav :class="{ 'flex': open, 'hidden': !open }"
                    class="flex-col items-center flex-grow hidden md:flex md:flex-row md:justify-end md:pb-0 md:space-x-6">
                    {{-- <a class="py-2 text-sm font-medium text-black hover:text-black/50" href="{{ route('register') }}">No
                        Account
                        Yet?</a> --}}

                    <a href="{{ route('login') }}"
                        class="font-medium text-sm active:bg-fuchsia-50 active:text-black bg-indigo-50 focus-visible:outline-2 cursor-pointer focus-visible:outline-fuchsia-50 focus-visible:outline-offset-2 focus:outline-none group hover:bg-[#0000ff]/5 hover:text-[#2F7A83] justify-center px-6 py-2.5 rounded-xl text-gray-600">Sign
                        In</a>
                </nav>
            </div>
        </div>
    </section>
    <section class="relative flex items-center w-full bg-gray-100">
        <div class="fixed hidden   right-0 w-96 bottom-0 top-0 z-10  bg-[#1A2634] 2xl:grid place-content-center">
            <img src="{{ asset('images/logo.jpg') }}" alt="">
        </div>
        <div class="fixed top-0 right-0 w-full bottom-0 bg-[#2F7A83]">

            <img src="{{ asset('images/noise.png') }}" class="absolute h-full w-full object-cover opacity-50"
                alt="">

        </div>
        <div class="relative items-center w-full px-5 py-24 mx-auto lg:px-16 lg:py-36 max-w-7xl md:px-12">
            <div class="relative flex-col items-start m-auto align-middle">
                <div class="grid grid-cols-1 gap-6 lg:gap-24 lg:grid-cols-2">
                    <div class="relative items-center gap-12 m-auto lg:inline-flex">
                        <div class="max-w-xl text-center lg:text-left">
                            <div>
                                <p class="text-3xl font-medium md:text-6xl text-white">
                                    Drive your design to a new age
                                </p>
                            </div>
                            <dl class="grid grid-cols-2 gap-4 mt-12 list-none lg:gap-6 text-pretty">
                                <div>
                                    <div class="font-extrabold text-3xl text-gray-400">01</div>

                                    <dd class="mt-2 text-md text-gray-200">
                                        The license comes with no warranties. The licensor provides the
                                        work "as is," and users must use it at their own risk.
                                    </dd>
                                </div>
                                <div>
                                    <div class="font-extrabold text-3xl text-gray-400">02</div>

                                    <dd class="mt-2 text-md text-gray-200">
                                        You are allowed to use the licensed work for both non-commercial
                                        and commercial purposes.
                                    </dd>
                                </div>
                                <div>
                                    <div class="font-extrabold text-3xl text-gray-400">03</div>

                                    <dd class="mt-2 text-md text-gray-200">
                                        You must give appropriate credit to the original creator of the
                                        work.
                                    </dd>
                                </div>
                                <div>
                                    <div class="font-extrabold text-3xl text-gray-400">04</div>

                                    <dd class="mt-2 text-md text-gray-200">
                                        The CC BY 3.0 License does not include a "Share Alike" (SA)
                                        provision.
                                    </dd>
                                </div>
                            </dl>

                        </div>
                    </div>
                    <div class="block w-full mt-12 lg:mt-0">
                        {{-- <img alt="hero"
                            class="object-cover object-center w-full mx-auto drop-shadow-xl lg:ml-auto rounded-2xl"
                            src="https://leaddelta.com/wp-content/uploads/2022/12/home-hero.svg"> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>
