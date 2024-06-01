<div class="bg-white p-5 mt-10 rounded-xl">
    <div class=" flex justify-between items-center">
        <div>
            <h1 class="font-semibold text-2xl">EXPENSES & REVENUE</h1>
            <div>
                <h1>Total Revenues: &#8369;{{ number_format($revenue, 2) }}</h1>
                <h1>Total Budget: &#8369;{{ number_format((75 / 100) * ($income - $expense), 2) }}</h1>
                <h1>Total Expenses: &#8369;{{ number_format($expense, 2) }}</h1>
            </div>
        </div>
        <div class="flex space-x-3">
            <x-native-select wire:model.live="month">
                <option>Month</option>
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                @endfor
            </x-native-select>
            <x-native-select wire:model.live="year">
                <option>Year</option>
                @foreach ($years as $item)
                    <option>{{ $item }}</option>
                @endforeach
            </x-native-select>
        </div>
    </div>
    <div class="mt-5 h-96 flex-1" wire:ignore x-data="{
        labels: $wire.entangle('labels'),
        submissions: $wire.entangle('chartValues'),
        init() {
            const data = {
                labels: this.labels,
                datasets: [{
                    label: '',
                    data: this.submissions,
                    {{-- borderColor: '#4CAF50', --}}
                    {{-- borderWidth: 2, --}}
                    backgroundColor: ['#FF5252', '#4CAF50']
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
                myChart.data.labels = this.labels;
                myChart.update();
            });
        }
    }">
        <canvas x-ref="canvas" id="charts" class="w-full" height="400"></canvas>
    </div>

</div>
