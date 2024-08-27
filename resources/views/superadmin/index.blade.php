<x-master-layout>
    {{-- <div>
        <div class="grid grid-cols-3 gap-10 ">
            <div class="col-span-2">
                <div class="  flex justify-between items-center">
                    <div>
                        <div>
                            <h1 class="font-semibold text-2xl">WEEKLY EXPENSES</h1>
                            <span class="text-sm">Expense from {{ now()->subDays(7)->format('F d, Y') }} -
                                {{ now()->format('F d, Y') }}</span>
                        </div>
                    </div>
                    <x-button label="View Report" right-icon="document-text" />

                </div>
                <div class="mt-5 h-96  flex-1">
                    <canvas id="myChart" class="w-full" height="400"></canvas>
                </div>

                <div class=" mt-10 flex justify-between items-center">
                    <div>
                        <div>
                            <h1 class="font-semibold text-2xl">EXPENSES & REVENUE</h1>
                            <span class="text-sm">Revenue and Expenses from September - December 2023</span>
                        </div>
                    </div>
                    <x-button label="View Report" right-icon="document-text" />

                </div>
                <div class="mt-5 h-96  flex-1">
                    <canvas id="myChart1" class="w-full" height="400"></canvas>
                </div>
            </div>
            <div>
                <div class="shadow-md p-5 rounded-xl bg-gray-100 ">
                    <h1 class="font-medium">Recently Used By</h1>
                    <div class="mt-5">
                        <ul role="list" class="divide-y divide-gray-100">
                            <li class="flex justify-between gap-x-6 py-5">
                                <div class="flex min-w-0 gap-x-4">
                                    <img class="h-12 w-12 flex-none rounded-full bg-gray-50"
                                        src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                        alt="">
                                    <div class="min-w-0 flex-auto">
                                        <p class="text-sm font-semibold leading-6 text-gray-900">Leslie Alexander</p>
                                        <p class="mt-1 truncate text-xs leading-5 text-gray-500">
                                            leslie.alexander@example.com</p>
                                    </div>
                                </div>
                                <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                                    <p class="text-sm leading-6 text-gray-900">{{ now()->format('d M Y') }}</p>
                                    <p class="mt-1 text-xs leading-5 text-gray-500">Last seen <time
                                            datetime="2023-01-23T13:23Z">3h ago</time></p>
                                </div>
                            </li>
                            <li class="flex justify-between gap-x-6 py-5">
                                <div class="flex min-w-0 gap-x-4">
                                    <img class="h-12 w-12 flex-none rounded-full bg-gray-50"
                                        src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                        alt="">
                                    <div class="min-w-0 flex-auto">
                                        <p class="text-sm font-semibold leading-6 text-gray-900">Leslie Alexander</p>
                                        <p class="mt-1 truncate text-xs leading-5 text-gray-500">
                                            leslie.alexander@example.com</p>
                                    </div>
                                </div>
                                <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                                    <p class="text-sm leading-6 text-gray-900">{{ now()->format('d M Y') }}</p>
                                    <p class="mt-1 text-xs leading-5 text-gray-500">Last seen <time
                                            datetime="2023-01-23T13:23Z">3h ago</time></p>
                                </div>
                            </li>
                            <li class="flex justify-between gap-x-6 py-5">
                                <div class="flex min-w-0 gap-x-4">
                                    <img class="h-12 w-12 flex-none rounded-full bg-gray-50"
                                        src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                        alt="">
                                    <div class="min-w-0 flex-auto">
                                        <p class="text-sm font-semibold leading-6 text-gray-900">Leslie Alexander</p>
                                        <p class="mt-1 truncate text-xs leading-5 text-gray-500">
                                            leslie.alexander@example.com</p>
                                    </div>
                                </div>
                                <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                                    <p class="text-sm leading-6 text-gray-900">{{ now()->format('d M Y') }}</p>
                                    <p class="mt-1 text-xs leading-5 text-gray-500">Last seen <time
                                            datetime="2023-01-23T13:23Z">3h ago</time></p>
                                </div>
                            </li>
                            <li class="flex justify-between gap-x-6 py-5">
                                <div class="flex min-w-0 gap-x-4">
                                    <img class="h-12 w-12 flex-none rounded-full bg-gray-50"
                                        src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                        alt="">
                                    <div class="min-w-0 flex-auto">
                                        <p class="text-sm font-semibold leading-6 text-gray-900">Leslie Alexander</p>
                                        <p class="mt-1 truncate text-xs leading-5 text-gray-500">
                                            leslie.alexander@example.com</p>
                                    </div>
                                </div>
                                <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                                    <p class="text-sm leading-6 text-gray-900">{{ now()->format('d M Y') }}</p>
                                    <p class="mt-1 text-xs leading-5 text-gray-500">Last seen <time
                                            datetime="2023-01-23T13:23Z">3h ago</time></p>
                                </div>
                            </li>
                            <li class="flex justify-between gap-x-6 py-5">
                                <div class="flex min-w-0 gap-x-4">
                                    <img class="h-12 w-12 flex-none rounded-full bg-gray-50"
                                        src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                        alt="">
                                    <div class="min-w-0 flex-auto">
                                        <p class="text-sm font-semibold leading-6 text-gray-900">Leslie Alexander</p>
                                        <p class="mt-1 truncate text-xs leading-5 text-gray-500">
                                            leslie.alexander@example.com</p>
                                    </div>
                                </div>
                                <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                                    <p class="text-sm leading-6 text-gray-900">{{ now()->format('d M Y') }}</p>
                                    <p class="mt-1 text-xs leading-5 text-gray-500">Last seen <time
                                            datetime="2023-01-23T13:23Z">3h ago</time></p>
                                </div>
                            </li>
                            <li class="flex justify-between gap-x-6 py-5">
                                <div class="flex min-w-0 gap-x-4">
                                    <img class="h-12 w-12 flex-none rounded-full bg-gray-50"
                                        src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                        alt="">
                                    <div class="min-w-0 flex-auto">
                                        <p class="text-sm font-semibold leading-6 text-gray-900">Leslie Alexander</p>
                                        <p class="mt-1 truncate text-xs leading-5 text-gray-500">
                                            leslie.alexander@example.com</p>
                                    </div>
                                </div>
                                <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                                    <p class="text-sm leading-6 text-gray-900">{{ now()->format('d M Y') }}</p>
                                    <p class="mt-1 text-xs leading-5 text-gray-500">Last seen <time
                                            datetime="2023-01-23T13:23Z">3h ago</time></p>
                                </div>
                            </li>
                            <li class="flex justify-between gap-x-6 py-5">
                                <div class="flex min-w-0 gap-x-4">
                                    <img class="h-12 w-12 flex-none rounded-full bg-gray-50"
                                        src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                        alt="">
                                    <div class="min-w-0 flex-auto">
                                        <p class="text-sm font-semibold leading-6 text-gray-900">Leslie Alexander</p>
                                        <p class="mt-1 truncate text-xs leading-5 text-gray-500">
                                            leslie.alexander@example.com</p>
                                    </div>
                                </div>
                                <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                                    <p class="text-sm leading-6 text-gray-900">{{ now()->format('d M Y') }}</p>
                                    <p class="mt-1 text-xs leading-5 text-gray-500">Last seen <time
                                            datetime="2023-01-23T13:23Z">3h ago</time></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Sample data


        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Label 1', 'Label 2', 'Label 3', 'Label 4', 'Label 5'],
                datasets: [{
                        label: 'Last 7 Days',
                        data: [10, 20, 30, 40, 50],
                        backgroundColor: '#040c74',
                    },
                    {
                        label: 'Last Week',
                        data: [15, 25, 35, 45, 55],
                        backgroundColor: '#e4ecec',

                    }
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        var ctx1 = document.getElementById('myChart1').getContext('2d');
        var myChart1 = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: ['Label 1', 'Label 2', 'Label 3', 'Label 4', 'Label 5'],
                datasets: [{
                        label: 'Last 7 Days',
                        data: [10, 20, 30, 40, 50],
                        backgroundColor: '#fd16ea',
                    },
                    {
                        label: 'Last Week',
                        data: [15, 25, 35, 45, 55],
                        backgroundColor: '#e4ecec',

                    },
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script> --}}
    <div>
        <livewire:admin-descriptive />
        <livewire:data-dashboard />
    </div>
</x-master-layout>
