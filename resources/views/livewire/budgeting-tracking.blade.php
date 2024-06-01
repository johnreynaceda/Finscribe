<div>
    <div class="w-7/12 flex space-x-3">
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
        <x-button label="Generate" wire:click="search" spinner="search" class="font-semibold" dark
            right-icon="search" />
    </div>
    <div class="mt-10">
        @if ($datas)
            <div class="w-96 border-2 shadow-lg overflow-hidden  rounded-xl">
                <h1 class="font-bold text-white p-2 bg-main  text-center">{{ $month_name ?? '' }}</h1>
                <div class="p-5 ">
                    <ul class="border-b">
                        @php
                            $income = $this->datas->sum('total_sales');
                            $expense = $this->spents->sum('total_expense');
                            $budget = $income - $expense;
                        @endphp
                        <li class="flex flex-1 justify-between items-center">
                            <span>&#8369;{{ number_format($income, 2) }}</span>
                            <span class="text-sm">Sales Revenue</span>
                        </li>
                        <li class="flex flex-1 justify-between items-center">
                            <span>&#8369;{{ number_format($expense, 2) }}</span>
                            <span class="text-sm">Overspent in {{ $month_name ?? '' }}</span>
                        </li>


                    </ul>
                    <div class="text-center mt-3">
                        <h1 class="text-sm">To Budget:</h1>
                        <h1 class="font-bold text-green-600 text-xl">&#8369;{{ number_format((75 / 100) * $budget, 2) }}
                        </h1>

                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="mt-20">
        @php
            $totalExpenses = 0; // Initialize total expenses variable
        @endphp
        @if ($spents)
            <table id="example" class="table-auto mt-5" style="width:100%">
                <thead class="font-normal">
                    <tr>
                        <th class="border text-right wi-64   px-2 text-sm font-semibold text-gray-700 py-2">

                        </th>

                        <th class="border text-right   px-2 text-sm font-semibold text-gray-700 py-2">
                            ACTUAL EXPENSE
                        </th>
                        <th class="border text-right   px-2 text-sm font-semibold text-gray-700 py-2">
                            ALLOTED BUDGET
                        </th>



                    </tr>
                </thead>
                <tbody class="">

                    @foreach ($expenses as $record)
                        @php
                            $total_budget = \App\Models\BudgetCategory::where(
                                'expense_category_id',
                                $record->id,
                            )->first()->amount;
                        @endphp
                        <tr>
                            <td class="w-64 border text-right  text-gray-700 font-bold  px-3 py-1">
                                {{ $record->name }}
                            </td>
                            <td class=" border text-right  text-gray-700 font-bold  px-3 py-1">

                            </td>
                            <td class=" border text-right  text-gray-700 font-bold  px-3 py-1">
                                &#8369;{{ number_format($total_budget, 2) }}
                            </td>
                        </tr>
                        @foreach ($collreection as $item)
                            {{-- <tr>

                            <td class=" w-64 border text-right  text-gray-700 font-bold  px-3 py-1">{{ $record->name }}
                            </td>

                            @if ($record->expenses->sum('total_expense') <= $total_budget)
                                <td class="border text-right font-semibold  text-green-700  px-3 py-1">
                                    &#8369;{{ number_format($record->expenses->sum('total_expense'), 2) }}</td>
                            @else
                                <td class="border text-right font-semibold  text-red-700  px-3 py-1">
                                    &#8369;{{ number_format($record->expenses->sum('total_expense'), 2) }}</td>
                            @endif
                            <td class="border text-right  text-gray-700  px-3 py-1">
                                &#8369;{{ number_format($total_budget, 2) }}
                            </td>


                        </tr>
                        @php
                            // Add the total expenses of the current record to the total expenses variable
                            $totalExpenses += $record->expenses->sum('total_expense');
                        @endphp --}}
                        @endforeach
                    @endforeach
                    <tr>
                        <td class="w-64 border text-right text-gray-700 font-bold px-3 py-1"></td>
                        <td class="border text-right font-bold text-red-700 px-3 py-1">
                            Total: &#8369;{{ number_format($totalExpenses, 2) }}</td>
                        <td class="border text-right font-bold text-red-700 px-3 py-1">
                        </td>
                    </tr>
                </tbody>
            </table>
        @endif
    </div>
</div>
