<div wire:ignore>
    <div class="bg-white p-5 rounded-xl">

        <div class="flex justify-between items-end">
            <h1 class="font-semibold">PREDICTIVE ANALYTICS</h1>
            <div class="flex items-center space-x-3">
                {{-- <x-native-select wire:model.live="month">
                    <option value="">Month</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                    @endfor
                </x-native-select> --}}
                {{-- <x-native-select wire:model.live="year">
                    <option value="">Year</option>
                    @foreach ($years as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                    @endforeach
                </x-native-select> --}}
            </div>
        </div>

        <div class="mt-5 h-96  flex-1" wire:ignore>
            <canvas id="myCharts" class="w-full" height="400"></canvas>
        </div>
        <script>
            document.addEventListener('livewire:init', () => {
                const labels = @json($labels);
                const revenue = @json($revenue);
                const budget = @json($budget);


                // Create a new Chart.js instance
                const ctx = document.getElementById('myCharts').getContext('2d');
                const myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                                label: 'Revenue',
                                data: revenue,
                                backgroundColor: '#00FF00',
                            },
                            {
                                label: 'Budget',
                                data: budget,
                                backgroundColor: '#FFFF00',
                            },

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
</div>
