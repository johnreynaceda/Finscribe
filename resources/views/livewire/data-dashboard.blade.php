<div>
    <div class="grid grid-cols-2 gap-10 ">
        <div>
            <div class=" p-5 bg-white rounded-xl">
                <div class="  flex justify-between items-center">
                    <div>
                        <div>
                            <h1 class="font-semibold text-2xl">WEEKLY EXPENSES</h1>
                            <span class="text-sm">Expense from {{ now()->subDays(7)->format('F d, Y') }} -
                                {{ now()->format('F d, Y') }}</span>
                        </div>
                    </div>
                    <x-button label="View Report" href="{{ route('stakeholder.expense') }}" right-icon="document-text" />

                </div>
                <div class="mt-5 h-96  flex-1" wire:ignore>
                    <canvas id="myChart" class="w-full" height="400"></canvas>
                </div>

                <div>
                    <livewire:dashboard-chart />
                </div>
            </div>
        </div>
        <div class="space-y-5">
            <div class="shadow-md p-5 rounded-xl bg-white">
                <h1 class="font-medium">Recently Used By</h1>
                <div class="mt-5">
                    <ul role="list" class="divide-y divide-gray-100">
                        @forelse (\App\Models\TimeRecord::whereDate('created_at', now())->orderBy('created_at', 'DESC')->take(5)->get() as $item)
                            <li class="flex justify-between gap-x-6 py-3">
                                <div class="flex min-w-0 gap-x-4">
                                    <x-avatar md label="{{ substr($item->user->name, 0, 2) }}" class="uppercase" warning
                                        border="thin" />
                                    <div class="min-w-0 flex-auto">
                                        <p class="text-sm font-semibold leading-6 text-gray-900 uppercase">
                                            {{ $item->user->name }}
                                        </p>
                                        <p class=" truncate text-xs leading-5 text-gray-500">
                                            {{ $item->user->email }}</p>
                                    </div>
                                </div>
                                <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                                    <p class="text-sm leading-6 text-gray-900">
                                        {{ \Carbon\Carbon::parse($item->created_at)->format('F d, Y') }}</p>
                                    <p class=" text-xs leading-5 text-gray-500">
                                        {{ \Carbon\Carbon::parse($item->start_time)->diffForHumans() }}</p>
                                </div>
                            </li>
                        @empty
                            <li class="py-5 text-center">
                                <span>No Login Users for Today!...</span>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <livewire:data-expense />

        </div>

    </div>
    <div class="mt-5">
        <livewire:descriptive-analytic />
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

        });
    </script>
</div>
