<div>
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
            <div class="mt-5 h-96  flex-1" wire:ignore>
                <canvas id="myChart" class="w-full" height="400"></canvas>
            </div>

            <div class=" mt-10 flex justify-between items-center">
                <div>
                    <div>
                        <h1 class="font-semibold text-2xl">EXPENSES & REVENUE</h1>
                        {{-- <span class="text-sm">Revenue and Expenses </span> --}}
                    </div>
                </div>
                <div class="flex space-x-3">
                    <x-native-select wire:model.live="month">
                        <option>Select Month</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </x-native-select>
                    <x-native-select wire:model.live="year">
                        <option>Select Year</option>
                        @foreach ($years as $item)
                            <option>{{ $item }}</option>
                        @endforeach

                    </x-native-select>
                </div>

            </div>
            <div class="mt-5 h-96  flex-1" wire:ignore>
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
    <script>
        document.addEventListener('livewire:init', () => {
            const labels = @json($labels);
            const dataThisWeek = @json($dataThisWeek);
            const dataLastWeek = @json($dataLastWeek);

            // Create a new Chart.js instance
            const ctx = document.getElementById('myChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'This Week',
                            data: dataThisWeek,
                            backgroundColor: '#040c74',
                        },
                        {
                            label: 'Last Week',
                            data: dataLastWeek,
                            backgroundColor: '#e4ecec',
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            const labelss = ['Expenses', 'Revenue'];
            const amounts = [@json($expense), @json($revenue)];
            // console.log(@json($expense));

            // Create a new Chart.js instance
            var ctx1 = document.getElementById('myChart1').getContext('2d');
            var myChart1 = new Chart(ctx1, {
                type: 'line',
                data: {
                    labels: labelss,
                    datasets: [{
                        label: 'Amount',
                        data: amounts,
                        backgroundColor: ['#880808',
                            '#059040'
                        ],

                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

        });
    </script>
</div>
