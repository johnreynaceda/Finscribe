<div>
    <div class=" p-2 px-4 flex justify-between border-b  py-3 items-center bg-white">
        <div class="flex space-x-2 items-center">
            <img src="{{ asset('images/logo.jpg') }}" class="h-12 w-12 rounded-full" alt="">
            <span class="text-2xl text-main">FinScribe</span>
        </div>
        <div class="">
            <div x-data="{
                dropdownOpen: false
            }" class="hidden 2xl:block relative">

                <button @click="dropdownOpen=true"
                    class="inline-flex items-center justify-center h-12 py-2 pl-3 pr-12 text-sm font-medium transition-colors text-gray-700 border rounded-md  hover:bg-neutral-100 active:bg-white focus:text-gray-700 focus:bg-white focus:outline-none disabled:opacity-50 disabled:pointer-events-none">
                    <img src="{{ asset('images/sample.png') }}"
                        class="object-cover w-8 h-8 border rounded-full bg-white border-neutral-200" />
                    <span class="flex flex-col items-start flex-shrink-0 h-full ml-2 leading-none translate-y-px">
                        <span class="">{{ auth()->user()->name }}</span>
                        <span class="text-xs font-light text-neutral-400">{{ auth()->user()->user_type }}</span>
                    </span>
                    <svg class="absolute right-0 w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                    </svg>
                </button>

                <div x-show="dropdownOpen" @click.away="dropdownOpen=false" x-transition:enter="ease-out duration-200"
                    x-transition:enter-start="-translate-y-2" x-transition:enter-end="translate-y-0"
                    class="absolute top-0 z-50 w-56 mt-12 -translate-x-1/2 left-1/2" x-cloak>
                    <div class="p-1 mt-1 bg-white border rounded-md shadow-md border-neutral-200/70 text-neutral-700">
                        <div class="px-2 py-1.5 text-sm font-semibold">My Account</div>
                        <div class="h-px my-1 -mx-1 bg-neutral-200"></div>
                        <a href="{{ route('profile.edit') }}"
                            class="relative flex cursor-default select-none hover:bg-neutral-100 items-center rounded px-2 py-1.5 text-sm outline-none transition-colors data-[disabled]:pointer-events-none data-[disabled]:opacity-50">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="w-4 h-4 mr-2">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <span>Profile</span>
                            <span class="ml-auto text-xs tracking-widest opacity-60">⇧⌘P</span>
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="route('logout')"
                                onclick="event.preventDefault();
                                        this.closest('form').submit();"
                                class="relative flex cursor-default select-none hover:bg-neutral-100 items-center rounded px-2 py-1.5 text-sm outline-none transition-colors focus:bg-accent focus:text-accent-foreground data-[disabled]:pointer-events-none data-[disabled]:opacity-50">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" x2="9" y1="12" y2="12">
                                    </line>
                                </svg>
                                <span>Log out</span>
                                <span class="ml-auto text-xs tracking-widest opacity-60">⇧⌘Q</span>
                            </a>
                        </form>
                    </div>
                </div>
            </div>

            <div x-data="{
                slideOverOpen: false
            }" class="relative z-50 w-auto h-auto 2xl:hidden">
                <button @click="slideOverOpen=true" class="text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>

                </button>
                <template x-teleport="body">
                    <div x-show="slideOverOpen" @keydown.window.escape="slideOverOpen=false" class="relative z-[99]">
                        <div x-show="slideOverOpen" x-transition.opacity.duration.600ms @click="slideOverOpen = false"
                            class="fixed inset-0 bg-black bg-opacity-10"></div>
                        <div class="fixed inset-0 overflow-hidden">
                            <div class="absolute inset-0 overflow-hidden">
                                <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
                                    <div x-show="slideOverOpen" @click.away="slideOverOpen = false"
                                        x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                                        x-transition:enter-start="translate-x-full"
                                        x-transition:enter-end="translate-x-0"
                                        x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                                        x-transition:leave-start="translate-x-0"
                                        x-transition:leave-end="translate-x-full" class="w-screen max-w-md">
                                        <div
                                            class="flex flex-col h-full py-5 overflow-y-scroll bg-main border-l shadow-lg border-neutral-100/70">
                                            <div class="px-4 sm:px-5">
                                                <div class="flex items-start justify-between pb-1">
                                                    <h2 class="text-base font-semibold leading-6 text-gray-900"
                                                        id="slide-over-title"></h2>
                                                    <div class="flex items-center h-auto ml-3">
                                                        <button @click="slideOverOpen=false"
                                                            class="absolute top-0 right-0 z-30 flex items-center justify-center bg-white px-3 py-2 mt-4 mr-5 space-x-1 text-xs font-medium uppercase border rounded-md border-neutral-200 text-neutral-600 hover:bg-neutral-100">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" class="w-4 h-4">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                            <span>Close</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="relative flex-1 px-4 mt-5 sm:px-5">
                                                <div class="mt-4">
                                                    <div
                                                        class="flex flex-col flex-grow pt-5 overflow-y-auto bg-main border-r">
                                                        <div class="flex flex-col flex-shrink-0 px-4">
                                                            {{-- <a class="text-lg font-semibold tracking-tighter text-white focus:outline-none focus:ring"
                                                                href="/">
                                                                <span class="inline-flex items-center gap-2">
                                                                    <img src="{{ asset('images/logo.jpg') }}" class="h-8" alt="">
                                                                    FinScribe
                                                                </span>
                                                            </a> --}}
                                                            <button
                                                                class="hidden rounded-lg focus:outline-none focus:shadow-outline">
                                                                <svg fill="currentColor" viewBox="0 0 20 20"
                                                                    class="size-6">
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
                                                                <img src="{{ asset('images/business_logo.png') }}"
                                                                    class="h-20" alt="">
                                                                <span
                                                                    class="mt-2 text-white uppercase">{{ auth()->user()->name }}</span>
                                                                <h1 class="text-xs text-gray-400">
                                                                    ({{ auth()->user()->user_type }})</h1>
                                                            </center>
                                                            <livewire:sidebar />
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>



        </div>
    </div>
</div>
