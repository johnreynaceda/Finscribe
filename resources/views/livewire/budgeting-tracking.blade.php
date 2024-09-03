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
            <div class="w-96 border-2 border-gray-700 shadow-lg overflow-hidden rounded-xl">
                <h1 class="font-bold text-white p-2 bg-main text-center">{{ $month_name ?? '' }}</h1>
                <div class="p-5">
                    <ul class="border-gray-700">
                        @php
                            $income = $datas->sum('total_sales');
                            $expense = $spents->sum('total_expense');
                            $budget = $income - $expense;
                        @endphp
                        <li class="flex justify-between items-center">
                            <span>&#8369;{{ number_format($income, 2) }}</span>
                            <span class="text-sm">Sales Revenue</span>
                        </li>
                        @if ($expense > $budget)
                            <li class="flex justify-between items-center">
                                <span>&#8369;{{ number_format($expense - $budget, 2) }}</span>
                                <span class="text-sm">Overspent in {{ $month_name ?? '' }}</span>
                            </li>
                        @endif
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
            $grandTotalExpenses = 0;
            $grandTotalAllottedBudget = 0;

        @endphp
        @if ($spents)
            <table id="example" class="table-auto mt-5 w-full">
                <thead class="font-normal">
                    <tr>
                        <th class="border-2 border-gray-700 text-right px-2 text-sm font-semibold text-gray-700 py-2">
                        </th>
                        <th class="border-2 border-gray-700 text-right px-2 text-sm font-semibold text-gray-700 py-2">
                            ACTUAL EXPENSE</th>
                        <th class="border-2 border-gray-700 text-right px-2 text-sm font-semibold text-gray-700 py-2">
                            ALLOTTED BUDGET</th>
                        <th class="border-2 border-gray-700 text-right px-2 text-sm font-semibold text-gray-700 py-2">
                            BUDGET SURPLUS/DEFICIT</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($expenses as $record)
                        @php
                            $total_budget =
                                \App\Models\BudgetCategory::where('expense_category_id', $record->id)->first()
                                    ->amount ?? 0;
                            $totalCategoryExpenses = 0;
                            $grandTotalAllottedBudget += $total_budget;

                            $expenseSubCategories = \App\Models\ExpenseSubCategory::whereHas('expenses', function (
                                $query,
                            ) {
                                $query
                                    ->whereYear('date', $this->year)
                                    ->whereMonth('date', $this->month)
                                    ->where('total_expense', '>', 0);
                            })
                                ->where('expense_category_id', $record->id)
                                ->with([
                                    'expenses' => function ($query) {
                                        // Eager load expenses filtered by month and year
                                        $query->whereYear('date', $this->year)->whereMonth('date', $this->month);
                                    },
                                ])
                                ->get();
                        @endphp
                        <tr>
                            <td colspan="2"
                                class="border-2 border-gray-700 text-left text-gray-700 font-bold px-3 py-1">
                                {{ $record->name }}</td>
                            <td class="border-2 border-gray-700 text-right text-gray-700 font-bold px-3 py-1">
                                &#8369;{{ number_format($total_budget, 2) }}</td>
                            <td class="border-2 border-gray-700 text-right text-gray-700 font-bold px-3 py-1"></td>
                        </tr>
                        @foreach ($expenseSubCategories as $item)
                            @php
                                // Calculate total expenses for each subcategory
                                $subCategoryExpenses = $item->expenses->sum('total_expense');
                                $totalCategoryExpenses += $subCategoryExpenses;
                                $grandTotalExpenses += $subCategoryExpenses;
                            @endphp
                            <tr>
                                <td class="border-2 border-gray-700 text-right text-gray-700 font-bold px-3 py-1">
                                    {{ $item->name }}
                                </td>
                                <td class="border-2 border-gray-700 text-right font-semibold px-3 py-1">
                                    &#8369;{{ number_format($subCategoryExpenses, 2) }}
                                </td>
                                <td class="border-2 border-gray-700 text-right text-gray-700 px-3 py-1"></td>
                                <td class="border-2 border-gray-700 text-right text-gray-700 px-3 py-1"></td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="border-2 border-gray-700 text-right text-gray-700 font-bold px-3 py-1"></td>
                            <td class="border-2 border-gray-700 text-right font-semibold text-gray-700 px-3 py-1">TOTAL:
                                &#8369;{{ number_format($totalCategoryExpenses, 2) }}</td>
                            <td class="border-2 border-gray-700 text-right text-gray-700 font-bold px-3 py-1">
                            </td>
                            <td
                                class="border-2 {{ $totalCategoryExpenses <= $total_budget ? 'text-green-700' : 'text-red-700' }} border-gray-700 text-right font-semibold px-3 py-1">
                                &#8369;{{ number_format($total_budget - $totalCategoryExpenses, 2) }}
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="border-2 border-gray-700 text-right text-gray-700 font-bold px-3 py-1"></td>
                        <td class="border-2 border-gray-700 text-right font-bold text-red-700 px-3 py-1"></td>
                        <td class="border-2 border-gray-700 text-right font-bold text-red-700 px-3 py-1"></td>
                        <td class="border-2 border-gray-700 text-right font-bold text-red-700 px-3 py-1"></td>
                    </tr>
                    <tr>
                        <td class="border-2 border-gray-700 text-right text-gray-700 font-bold px-3 py-1"></td>
                        <td class="border-2 border-gray-700 text-right font-bold text-gray-700 px-3 py-1">
                            &#8369;{{ number_format($grandTotalExpenses, 2) }}</td>
                        <td class="border-2 border-gray-700 text-right font-bold text-gray-700 px-3 py-1">
                            &#8369;{{ number_format($grandTotalAllottedBudget, 2) }}</td>
                        <td class="border-2 border-gray-700 text-right font-bold text-gray-700 px-3 py-1">
                            &#8369;{{ number_format($grandTotalAllottedBudget - $grandTotalExpenses, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </div>
</div>
