<div wire:ignore>
    <div class="bg-white p-5 rounded-xl">

        <div class="flex justify-between items-end">
            <h1 class="font-semibold">PREDICTIVE ANALYTICS</h1>
            <div class="flex items-center space-x-3">
                <x-native-select wire:model.live="month">
                    <option value="">Month</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                    @endfor
                </x-native-select>
                <x-native-select wire:model.live="year">
                    <option value="">Year</option>
                    @foreach ($years as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                    @endforeach
                </x-native-select>
            </div>
        </div>

        <div class="mt-5 h-96 flex-1" wire:ignore x-data="{
        
            submissions: $wire.entangle('chartValues'),
            init() {
                const data = {
                    labels: ['NET INCOME', 'BUDGET'],
                    datasets: [{
                        label: '',
                        data: this.submissions,
                        {{-- borderColor: '#4CAF50', --}}
                        {{-- borderWidth: 2, --}}
                        backgroundColor: ['#4CAF50', '#FFFF00', '#0000FF']
                    }]
                };
                const myChart = new Chart(this.$refs.canvas, {
                    type: 'bar',
                    data: data,
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
        
                Livewire.on('updateChart', () => {
                    myChart.data.datasets[0].data = this.submissions;
                    {{-- console.log(this.submissions); --}}
                    {{-- myChart.data.labels = this.labels; --}}
                    myChart.update();
                });
            }
        }">
            <canvas x-ref="canvas" id="charts" class="w-full" height="400"></canvas>
        </div>
    </div>
</div>
