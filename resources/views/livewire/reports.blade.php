<div x-data>
    @php
        $totalExpenses = 0;
        $net_income = 0;
    @endphp
    <div class="flex justify-between items-center">
        <div class="flex space-x-3 items-center">
            <div class="w-64">
                <x-native-select label="Select Report" wire:model.live="report_type">
                    <option>Select an Option</option>
                    <option>Income</option>
                    <option>Budget</option>
                    <option>Cash Flow</option>

                </x-native-select>
            </div>
            <div class="w-64">
                <x-native-select label="Select Month" wire:model.live="month">
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
            </div>
            <div class="w-64">
                <x-native-select label="Select Year" wire:model.live="year">
                    <option>Select Year</option>
                    @foreach ($years as $item)
                        <option>{{ $item }}</option>
                    @endforeach

                </x-native-select>
            </div>
        </div>
        <div>
            {{-- <x-button label="PRINT REPORT" @click="printOut($refs.printContainer.outerHTML);" class="font-semibold"
                icon="printer" dark /> --}}
        </div>
    </div>
    {{-- @dump($report_type) --}}
    <div class="mt-10 ">
        @if ($report_type)
            @switch($report_type)
                @case('Income')
                    <div class="border border-gray-500 p-5 rounded-xl bg-white" x-ref="printContainer">
                        <div class="flex justify-between">
                            <div class="flex space-x-2 items-center">
                                <img src="{{ asset('images/business_logo.png') }}" class="h-20" alt="">
                                <h1 class="font-bold text-xl">Mi Pares</h1>
                            </div>
                            <div class="text-right">
                                <h1 class="text-blue-700 font-bold text-2xl">Income Statement</h1>
                                <h1 class="text-gray-700">For the month of {{ $month_name ?? 'No Month Selected' }}
                                    {{ $year ?? 'No Year Selected' }}
                                </h1>
                            </div>
                        </div>
                        <div class="mt-5 bg-blue-700 p-2 px-5 flex justify-between">
                            <h1 class="font-medium text-white">Revenue</h1>

                            <h1 class="font-medium text-white">{{ $month_name }}
                                {{ $first_day . '-' . $last_day . ', ' . $year }}
                            </h1>
                        </div>
                        <div>
                            <li class="flex justify-between p-2">
                                <h1 class="pl-20"> Sales Revenue</h1>
                                <h1> &#8369;{{ number_format($incomes->sum('total_sales'), 2) }}</h1>
                            </li>
                            <div class="flex border-t-2 justify-between bg-gray-200 p-2">
                                <h1 class="font-bold text-lg"> TOTAL REVENUE</h1>
                                <h1 class="font-bold text-lg"> &#8369;{{ number_format($incomes->sum('total_sales'), 2) }}</h1>
                            </div>
                        </div>
                        <div class="mt-2 bg-blue-700 p-2 px-5 flex justify-between">
                            <h1 class="font-medium text-white">EXPENSES</h1>

                        </div>
                        <div>
                            @php
                                $totalExpenses = 0; // Initialize total expenses variable
                            @endphp
                            @foreach ($expenses as $item)
                                <li class="flex justify-between bg-blue-100 p-2">
                                    <h1 class="pl-20 font-bold  text-xl">{{ $item->name }}</h1>
                                    {{-- <h1>&#8369;{{ number_format($item->expenses->sum('total_expense'), 2) }}</h1> --}}
                                </li>
                                @foreach (\App\Models\ExpenseSubCategory::where('expense_category_id', $item->id)->whereHas('expenses', function ($q) {
                    $q->whereYear('date', $this->year)->whereMonth('date', $this->month)->where('total_expense', '>', 0);
                })->get() as $record)
                                    <li class="flex justify-between p-1">
                                        <h1 class="pl-20 ">{{ $record->name }}</h1>
                                        <h1>&#8369;{{ number_format($record->expenses->sum('total_expense'), 2) }}</h1>
                                    </li>
                                    @php
                                        $totalExpenses += $record->expenses->sum('total_expense');
                                    @endphp
                                @endforeach
                            @endforeach
                            <div class="flex justify-between border-t-2 bg-gray-200 p-2">
                                <h1 class="font-bold text-lg"> TOTAL EXPENSE</h1>
                                <h1 class="font-bold text-lg">&#8369;{{ number_format($totalExpenses, 2) }}</h1>
                            </div>
                        </div>
                        <div class="mt-10 border-t-2 flex justify-between bg-gray-100 p-2">
                            <h1 class="font-bold text-lg">NET INCOME</h1>
                            @php
                                $net_income = $incomes->sum('total_sales') - $totalExpenses;
                            @endphp
                            @if ($net_income < 0)
                                <h1 class="font-bold text-red-600 text-lg"> &#8369;{{ number_format($net_income, 2) }}</h1>
                            @else
                                <h1 class="font-bold text-green-600 text-lg"> &#8369;{{ number_format($net_income, 2) }}</h1>
                            @endif
                        </div>
                        <div class="mt-5 ">
                            @php
                                $before_taxes = $incomes->sum('total_sales') - $totalExpenses;
                                $tax_expense = $before_taxes * 0.3;
                            @endphp
                            <li class="flex justify-between bg-blue-200 font-bold">
                                <h1 class="pl-20">Net Income before Taxes</h1>
                                <h1>&#8369;{{ number_format($before_taxes, 2) }}</h1>
                            </li>
                            <li class="flex justify-between bg-blue-200 font-bold">
                                <h1 class="pl-20">Income Tax Expense</h1>
                                <h1>&#8369;{{ number_format($tax_expense, 2) }}</h1>
                            </li>
                        </div>
                        <div class="mt-5 border-t-2 flex justify-between bg-gray-200 p-2">
                            <h1 class="font-bold text-lg">INCOME FROM CONTINUING OPERATIONS</h1>
                            <h1 class="font-bold  text-lg"> &#8369;{{ number_format($before_taxes - $tax_expense, 2) }}</h1>

                        </div>
                        <div class="mt-5">
                            <li class="flex justify-between bg-blue-200 ">
                                <h1 class="pl-20 font-bold">Gross Profit </h1>
                                <h1>TOTAL REVENUE - COST OF GOODS SOLD</h1>
                            </li>
                            <li class="flex justify-between bg-blue-200 font-bold">
                                <h1 class="pl-20">Net Income</h1>
                                <h1>&#8369;{{ number_format($before_taxes - $tax_expense, 2) }}</h1>
                            </li>

                        </div>
                        <div class="mt-5">
                            <x-button label="PRINT REPORT" @click="printOut($refs.printContainer.outerHTML);"
                                class="font-semibold" icon="printer" dark />
                        </div>
                    </div>
                @break

                @case(2)
                @break

                @default
            @endswitch
        @endif
    </div>
</div>
