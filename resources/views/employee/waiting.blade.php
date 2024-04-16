<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />

    <meta name="application-name" content="{{ config('app.name') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>{{ config('app.name') }}</title>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    @filamentStyles
    @vite('resources/css/app.css')
</head>

<body class="antialiased">
    <div class="fixed  right-0 w-96 bottom-0 top-0 z-10  bg-[#1A2634] grid place-content-center">
        <img src="{{ asset('images/logo.jpg') }}" alt="">
    </div>
    <div class="fixed left-0 bottom-10 w-full right-0 text-center">
        © 2023 All Rights Reserved. FinScribe
    </div>
    <section class="fixed h-full w-full">
        <div class="px-8 py-32 mx-auto md:px-12 lg:px-32 max-w-7xl">
            <div>
                <div>
                    <span class=" font-semibold text-green-600 uppercase">Welcome User,
                        {{ auth()->user()->name }}</span>
                    @if (auth()->user()->account_status == 'rejected')
                        <p class="mt-8 text-4xl font-semibold tracking-tighter text-main text-balance lg:text-6xl">
                            Your request has been rejected.
                        </p>
                    @else
                        <p class="mt-8 text-4xl font-semibold tracking-tighter text-main text-balance lg:text-6xl">
                            Please Wait for the verification process to complete.
                        </p>
                        <p class="mx-auto mt-4 text-sm font-medium text-gray-500 text-balance">
                            We will send you an email for the update. Thank you.
                        </p>
                    @endif
                </div>
                <div class="flex flex-col items-center gap-2 mx-auto mt-8 md:flex-row">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="route('logout')"
                            onclick="event.preventDefault();
                            this.closest('form').submit();"
                            class="inline-flex items-center justify-center w-full h-12 gap-3 px-5 py-3 font-medium text-white duration-200 bg-gray-900 md:w-auto rounded-xl hover:bg-gray-700 focus:ring-2 focus:ring-offset-2 focus:ring-black"
                            aria-label="Primary action">
                            <span>Logout Account</span>

                        </a>
                    </form>
                </div>
            </div>
        </div>
    </section>



    @livewire('notifications')

    @filamentScripts
    @vite('resources/js/app.js')
</body>

</html>
