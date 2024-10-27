<div x-data>
    @php
        $totalExpenses = 0;
        $net_income = 0;
        $grandTotalExpenses_current = 0;
        $grandTotalExpenses_previous = 0;
        $total_increase_decrease = 0;

        $current_end_cashflow = 0;
        $current_begin_cashflow = 0;

        $previous_end_cashflow = 0;
        $previous_begin_cashflow = 0;

        $current_sales = 0;
        $previous_sales = 0;
    @endphp
    <div class="flex justify-between items-center">
        <div class="flex space-x-3 items-center">
            <div class="w-64">
                <x-native-select label="Select Report" wire:model.live="report_type">
                    <option>Select an Option</option>
                    <option value="Income">Income Statement</option>
                    <option value="Budget">Budget Statement</option>
                    <option value="Cash Flow">Cash Flow Statement</option>

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
                                @php
                                    $expenseSubCategories = \App\Models\ExpenseSubCategory::whereHas(
                                        'expenses',
                                        function ($query) {
                                            $query
                                                ->whereYear('date', $this->year)
                                                ->whereMonth('date', $this->month)
                                                ->where('total_expense', '>', 0);
                                        },
                                    )
                                        ->where('expense_category_id', $item->id)
                                        ->with([
                                            'expenses' => function ($query) {
                                                // Eager load expenses filtered by month and year
                                                $query
                                                    ->whereYear('date', $this->year)
                                                    ->whereMonth('date', $this->month);
                                            },
                                        ])
                                        ->get();
                                @endphp
                                <li class="flex justify-between bg-blue-100 p-2">
                                    <h1 class="pl-20 font-bold  text-xl">{{ $item->name }}</h1>
                                    {{-- <h1>&#8369;{{ number_format($item->expenses->sum('total_expense'), 2) }}</h1> --}}
                                </li>
                                @foreach ($expenseSubCategories as $record)
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
                        {{-- <div class="mt-5">
                            <li class="flex justify-between bg-blue-200 ">
                                <h1 class="pl-20 font-bold">Gross Profit </h1>
                                @php
                                    $category = \App\Models\ExpenseCategory::where(
                                        'name',
                                        'like',
                                        '%' . 'COST OF GOODS SOLD' . '%',
                                    )->first()->id;

                                    $total_expense_sub = \App\Models\Expense::whereHas('expenseSubCategory', function (
                                        $cat,
                                    ) use ($category) {
                                        $cat->where('expense_category_id', $category);
                                    })->sum('total_expense');
                                @endphp
                                <h1 class="font-bold ">
                                    &#8369;{{ number_format($incomes->sum('total_sales') - $total_expense_sub), 2 }}</h1>
                            </li>
                            <li class="flex justify-between bg-blue-200 font-bold">
                                <h1 class="pl-20">Net Income</h1>
                                <h1>&#8369;{{ number_format($before_taxes - $tax_expense, 2) }}</h1>
                            </li>

                        </div> --}}
                        <div class="mt-5">
                            <li class="flex justify-between bg-blue-200 ">
                                <h1 class="pl-20 font-bold">Gross Profit </h1>
                                @php
                                    $category = \App\Models\ExpenseCategory::where(
                                        'name',
                                        'like',
                                        '%' . 'Cost of Goods Sold (COGS)' . '%',
                                    )->first()->id;

                                    $total_expense_sub = \App\Models\Expense::whereHas('expenseSubCategory', function (
                                        $cat,
                                    ) use ($category) {
                                        $cat->where('expense_category_id', $category);
                                    })
                                        ->whereYear('date', $this->year)
                                        ->whereMonth('date', $this->month)
                                        ->sum('total_expense');

                                @endphp
                                <h1 class="font-bold ">
                                    &#8369;{{ number_format($incomes->sum('total_sales') - $total_expense_sub, 2) }}</h1>
                                {{-- {{ $total_expense_sub }} --}}
                                <!-- Fixed this line -->
                            </li>
                            <li class="flex justify-between bg-blue-200 font-bold">
                                <h1 class="pl-20">Net Income</h1>
                                <h1>&#8369;{{ number_format($before_taxes - $tax_expense, 2) }}</h1>
                            </li>
                        </div>

                        <div class="mt-5">
                            <x-button label="PRINT REPORT" @click="printOut($refs.printContainer.outerHTML);"
                                wire:click="incomeReport" class="font-semibold" icon="printer" dark />
                        </div>
                    </div>
                @break

                @case('Budget')
                    <div x-ref="printContainer" class="bg-white p-10 rounded-xl">
                        <h1 class="text-2xl font-bold text-red-400">MI PARES - BUDGET STATEMENT</h1>
                        <div class="mt-2">
                            <h1 class="text-xl font-semibold text-blue-500">FOR THE MONTH OF</h1>
                            <h1 class="text-xl font-semibold uppercase text-blue-500">{{ $month_name }} {{ $year }}
                            </h1>
                        </div>
                        <div class="mt-5 grid grid-cols-3">
                            <div class="flex justify-end items-center pr-5">
                                SUMMARY
                            </div>
                            <div class="col-span-2">
                                <table id="example" class="table-auto mt-5 w-full">
                                    <thead class="font-normal">
                                        <tr>
                                            <th class="border bg-black text-right px-2 text-sm font-semibold text-white py-1">
                                                TOTAL REVENUES
                                            </th>
                                            <th class="border bg-black text-right px-2 text-sm font-semibold text-white py-1">
                                                TOTAL BUDGET
                                            </th>
                                            <th class="border bg-black text-right px-2 text-sm font-semibold text-white py-1">
                                                TOTAL EXPENSE
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td class="border text-right text-gray-700 px-3 py-1">
                                                &#8369; {{ number_format($datas->sum('total_sales'), 2) }}
                                            </td>
                                            <td class="border text-right text-gray-700 px-3 py-1">
                                                &#8369; {{ number_format($budgets, 2) }}
                                            </td>
                                            <td class="border text-right text-gray-700 px-3 py-1">
                                                &#8369; {{ number_format($spents->sum('total_expense'), 2) }}
                                            </td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="mt-5">
                            @php
                                $grandTotalExpenses = 0;
                                $grandTotalAllottedBudget = 0;
                            @endphp
                            <table id="example" class="table-auto mt-5 w-full">
                                <thead class="font-normal">
                                    <tr>
                                        <th class="border  text-gray-600 px-2 text-sm font-semibold text-white py-1">
                                            EXPENSES
                                        </th>
                                        <th class="border  text-gray-600 px-2 text-sm font-semibold text-white py-1">
                                            EXPENSE AMOUNT
                                        </th>
                                        <th class="border  text-gray-600 px-2 text-sm font-semibold text-white py-1">
                                            TOTAL BUDGET
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($budget_expenses as $expense)
                                        @php
                                            $total_budget =
                                                \App\Models\BudgetCategory::where(
                                                    'expense_category_id',
                                                    $expense->id,
                                                )->first()->amount ?? 0;
                                            $totalCategoryExpenses = 0;
                                            $grandTotalAllottedBudget += $total_budget;

                                            $expenseSubCategories = \App\Models\ExpenseSubCategory::whereHas(
                                                'expenses',
                                                function ($query) {
                                                    $query
                                                        ->whereYear('date', $this->year)
                                                        ->whereMonth('date', $this->month)
                                                        ->where('total_expense', '>', 0);
                                                },
                                            )
                                                ->where('expense_category_id', $expense->id)
                                                ->with([
                                                    'expenses' => function ($query) {
                                                        // Eager load expenses filtered by month and year
                                                        $query
                                                            ->whereYear('date', $this->year)
                                                            ->whereMonth('date', $this->month);
                                                    },
                                                ])
                                                ->get();
                                        @endphp
                                        <tr>
                                            <td colspan="2"
                                                class="border text-left font-semibold uppercase text-gray-700 px-3 py-1">
                                                {{ $expense->name }}
                                            </td>
                                            <td class="border text-right font-semibold uppercase text-gray-700 px-3 py-1">
                                                &#8369; {{ number_format($total_budget, 2) }}
                                            </td>
                                        </tr>

                                        @foreach ($expenseSubCategories as $item)
                                            @php
                                                // Calculate subcategory expenses directly using Eloquent relationship
                                                $subCategoryExpenses = $item->expenses->sum('total_expense');

                                                // Add to the category and grand totals
                                                $totalCategoryExpenses += $subCategoryExpenses;
                                                $grandTotalExpenses += $subCategoryExpenses;
                                            @endphp
                                            <tr>
                                                <td class="border text-right text-gray-700 px-3 py-1">
                                                    {{ $item->name }}
                                                </td>
                                                <td class="border text-right text-gray-700 px-3 py-1">
                                                    &#8369;{{ number_format($subCategoryExpenses, 2) }}
                                                </td>
                                                <td class="border text-right text-gray-700 px-3 py-1">
                                                    <!-- Additional cells if needed -->
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td
                                                class="border bg-gray-100 text-right font-semibold uppercase text-gray-700 px-3 py-1">
                                                TOTAL
                                            </td>
                                            <td
                                                class="border bg-gray-100 text-right font-semibold uppercase text-gray-700 px-3 py-1">
                                                &#8369;{{ number_format($totalCategoryExpenses, 2) }}
                                            </td>
                                            <td
                                                class="border bg-gray-100 text-right font-semibold uppercase text-gray-700 px-3 py-1">
                                                &#8369;{{ number_format($total_budget - $totalCategoryExpenses, 2) }}
                                            </td>
                                        </tr>
                                        <td colspan="3"
                                            class="border text-right font-semibold uppercase text-gray-700 px-3 py-1"></td>
                                    @endforeach
                                    <tr>
                                        <td class="border text-right font-semibold uppercase text-gray-700 px-3 py-1">
                                            TOTAL
                                        </td>
                                        <td class="border text-right font-semibold uppercase text-gray-700 px-3 py-1">
                                            &#8369;{{ number_format($grandTotalExpenses, 2) }}
                                        </td>
                                        <td class="border text-right font-semibold uppercase text-gray-700 px-3 py-1">
                                            &#8369;{{ number_format($grandTotalAllottedBudget - $grandTotalExpenses, 2) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mt-5">
                        <x-button label="PRINT REPORT" @click="printOut($refs.printContainer.outerHTML);"
                            wire:click="budgetReport" class="font-semibold" icon="printer" dark />
                    </div>
                @break

                @case('Cash Flow')
                    <div x-ref="printContainer" class="bg-white p-5 rounded-xl">
                        <h1 class="text-2xl font-bold text-red-400">MI PARES - CASH FLOW STATEMENT</h1>
                        <div class="mt-2">
                            <h1 class="text-xl font-semibold uppercase text-blue-500">FOR THE MONTH OF {{ $month_name }}
                                {{ $year }}</h1>
                        </div>
                        <div class="mt-5 grid grid-cols-3">
                            <div class="">
                                <table id="example" class="table-auto mt-5 w-full">
                                    <thead class="font-normal">
                                        <tr>
                                            <th
                                                class="border bg-blue-300 text-left px-2 text-sm font-semibold text-gray-600 py-1">
                                                COMPANY NAME
                                            </th>


                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td class="border text-left text-gray-700 px-3 py-1">
                                                MI PARES
                                            </td>


                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-span-2">
                                <table id="example" class="table-auto mt-5 w-full">
                                    <thead class="font-normal">
                                        <tr>
                                            <th
                                                class="border bg-blue-300 text-right px-2 text-sm font-semibold text-gray-600 py-1">
                                                FINANCIAL MANAGER NAME
                                            </th>
                                            <th
                                                class="border bg-blue-300 text-right px-2 text-sm font-semibold text-gray-600 py-1">
                                                COMPLETED BY:
                                            </th>
                                            <th
                                                class="border bg-blue-300 text-right px-2 text-sm font-semibold text-gray-600 py-1">
                                                DATE COMPLETED
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td class="border text-right text-gray-700 px-3 py-1">
                                                Janica Besonia
                                            </td>
                                            <td class="border text-right text-gray-700 px-3 py-1">
                                                Janica Besonia

                                            </td>
                                            <td class="border text-right text-gray-700 px-3 py-1">

                                            </td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class=" grid grid-cols-3">
                            <div class="">

                            </div>
                            <div class="col-span-2">
                                <table id="example" class="table-auto mt-5 w-full">
                                    <thead class="font-normal">
                                        <tr>
                                            <th class="border  text-gray-600 px-2 uppercase text-sm font-semibold  py-1">
                                                CURRENT MONTH ({{ $month_name }})
                                            </th>
                                            <th class="border  text-gray-600 px-2 text-sm uppercase font-semibold  py-1">
                                                PREVIOUS MONTH ({{ $previous_month_name }})
                                            </th>
                                            <th class="border  text-gray-600 px-2 text-sm font-semibold  py-1">
                                                INCREASE (or DECREASE)
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $current_end_inflow = \App\Models\Income::whereYear('date', $this->year)
                                                ->whereMonth('date', $this->month)
                                                ->sum('total_sales');
                                            $current_begin_inflow = \App\Models\Income::whereYear('date', $this->year)
                                                ->whereMonth('date', $this->month - 1)
                                                ->sum('total_sales');

                                            $current_end_outflow = \App\Models\Expense::whereYear('date', $this->year)
                                                ->whereMonth('date', $this->month)
                                                ->sum('total_expense');
                                            $current_begin_outflow = \App\Models\Expense::whereYear('date', $this->year)
                                                ->whereMonth('date', $this->month - 1)
                                                ->sum('total_expense');

                                            //previous
                                            $previous_end_inflow = \App\Models\Income::whereYear('date', $this->year)
                                                ->whereMonth('date', $this->month - 1)
                                                ->sum('total_sales');
                                            $previous_begin_inflow = \App\Models\Income::whereYear('date', $this->year)
                                                ->whereMonth('date', $this->month - 2)
                                                ->sum('total_sales');

                                            $previous_end_outflow = \App\Models\Expense::whereYear('date', $this->year)
                                                ->whereMonth('date', $this->month - 1)
                                                ->sum('total_expense');
                                            $previous_begin_outflow = \App\Models\Expense::whereYear(
                                                'date',
                                                $this->year,
                                            )
                                                ->whereMonth('date', $this->month - 2)
                                                ->sum('total_expense');

                                            $current_end_cashflow = $current_end_inflow - $current_end_outflow;
                                            $current_begin_cashflow = $current_begin_inflow - $current_begin_outflow;

                                            $previous_end_cashflow = $previous_end_inflow - $previous_end_outflow;
                                            $previous_begin_cashflow = $previous_begin_inflow - $previous_begin_outflow;

                                            $current_sales = $current_end_inflow;
                                            $previous_sales = $current_begin_inflow;
                                        @endphp
                                        <tr>
                                            <td class="border text-right  text-gray-600  px-3 ">
                                                <div class="grid grid-cols-2 text-center">
                                                    <div class="border-r  pr-2">
                                                        BEGIN
                                                    </div>
                                                    <div>
                                                        END
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="border text-right  text-gray-600  px-3 ">
                                                <div class="grid grid-cols-2 text-center">
                                                    <div class="border-r  pr-2">
                                                        BEGIN
                                                    </div>
                                                    <div>
                                                        END
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="border-x border-t text-right text-gray-700  px-3 ">

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border   px-3 ">
                                                <div class="grid grid-cols-2 text-center">
                                                    <div class="border-r  pr-2">
                                                        &#8369; {{ number_format($current_begin_cashflow, 2) }}
                                                    </div>
                                                    <div>
                                                        &#8369; {{ number_format($current_end_cashflow, 2) }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="border   px-3 ">
                                                <div class="grid grid-cols-2 text-center">
                                                    <div class="border-r  pr-2">
                                                        &#8369; {{ number_format($previous_begin_cashflow, 2) }}
                                                    </div>
                                                    <div>
                                                        &#8369; {{ number_format($previous_end_cashflow, 2) }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="border-x border-b text-right text-gray-700  px-3 ">

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class=" grid grid-cols-3">
                            <div class="">
                                <table id="example" class="table-auto  w-full">
                                    <thead class="font-normal">
                                        <tr>
                                            <th class=" text-center px-2 uppercase text-sm font-semibold text-white py-1">
                                                CURRENT MONTHY ({{ $month_name }})
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="border text-center font-semibold text-gray-700  px-3 ">
                                                BEGINNING BALANCE | CASH ON HAND
                                            </td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-span-2">
                                <table id="example" class="table-auto  w-full">
                                    <thead class="font-normal">
                                        <tr>
                                            <th class="text-center px-2 uppercase text-sm font-semibold text-white py-1">
                                                CURRENT MONTHY ({{ $month_name }})
                                            </th>
                                            <th class="text-center px-2 text-sm uppercase font-semibold text-white py-1">
                                                PREVIOUS MONTH ({{ $previous_month_name }})
                                            </th>
                                            <th class="text-center px-2 text-sm font-semibold text-white py-1">
                                                INCREASE (or DECREASE)
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="border text-right text-gray-700  px-3 ">
                                                &#8369;{{ number_format($current_begin_cashflow, 2) }}
                                            </td>
                                            <td class="border text-right text-gray-700  px-3 ">
                                                &#8369;{{ number_format($previous_begin_cashflow, 2) }}
                                            </td>
                                            <td class="border text-right text-gray-700  px-3 ">
                                                &#8369;{{ number_format($current_begin_cashflow - $previous_begin_cashflow, 2) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="mt-5">
                            <table id="example" class="table-auto  w-full">
                                <thead class="font-normal">

                                    <tr>
                                        <th
                                            class=" w-[26rem] border-y border-l  text-start px-2 uppercase text-sm font-semibold text-gray-700 py-1">
                                            ( + ) CASH RECEIPTSS
                                        </th>
                                        <th
                                            class=" w-[19rem] border-t  text-center px-2 text-sm uppercase font-semibold text-transparent py-1">
                                            PREVIOUS MONTH ({{ $previous_month_name }})
                                        </th>
                                        <th
                                            class="w-[17rem] border-t text-center px-2 text-sm font-semibold text-transparent py-1">
                                            INCREASE (or DECREASE)
                                        </th>
                                        <th
                                            class=" text-center border-t border-r px-2 text-sm font-semibold text-transparent py-1">
                                            INCREASE (or DECREASE)
                                        </th>


                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border text-left text-sm  text-gray-700  px-3 ">
                                            MI PARES SALES REVENUES
                                        </td>
                                        <td class="border text-right text-sm text-gray-700  px-3 ">
                                            &#8369;{{ number_format($current_sales, 2) }}
                                        </td>
                                        <td class="border text-right text-sm text-gray-700  px-3 ">
                                            &#8369;{{ number_format($previous_sales, 2) }}
                                        </td>
                                        <td class="border text-right text-sm text-gray-700  px-3 ">
                                            &#8369; {{ number_format($current_sales - $previous_sales, 2) }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="border text-left text-sm font-bold  text-gray-700  px-3 ">
                                            TOTAL CASH RECEIPTS
                                        </td>
                                        <td class="border text-right text-sm text-gray-700  px-3 ">
                                            &#8369;{{ number_format($current_sales, 2) }}
                                        </td>
                                        <td class="border text-right text-sm text-gray-700  px-3 ">
                                            &#8369;{{ number_format($previous_sales, 2) }}
                                        </td>
                                        <td class="border text-right text-sm text-gray-700  px-3 ">
                                            &#8369; {{ number_format($current_sales - $previous_sales, 2) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @foreach ($budget_expenses as $item)
                            @php
                                $totalCategoryExpenses_current = 0;
                                $totalCategoryExpenses_previous = 0;

                            @endphp
                            <div class="mt-5">
                                <table id="example" class="table-auto  w-full">
                                    <thead class="font-normal">

                                        <tr>
                                            <th
                                                class=" w-[26rem] border-y border-l  text-start px-2 uppercase text-sm font-semibold text-gray-700 py-1">
                                                (-)
                                                {{ $item->name }}
                                            </th>
                                            <th
                                                class=" w-[19rem] border-t  text-center px-2 text-sm uppercase font-semibold text-transparent py-1">
                                                PREVIOUS MONTH
                                            </th>
                                            <th
                                                class="w-[17rem] border-t text-center px-2 text-sm font-semibold text-transparent py-1">
                                                INCREASE (or DECREASE)
                                            </th>
                                            <th
                                                class=" text-center border-t border-r px-2 text-sm font-semibold text-transparent py-1">
                                                INCREASE (or DECREASE)
                                            </th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (\App\Models\ExpenseSubCategory::where('expense_category_id', $item->id)->whereHas('expenses', function ($record) {
                    return $record->whereYear('date', $this->year)->whereMonth('date', $this->month)->where('total_expense', '>', 0);
                })->get() as $record)
                                            @php
                                                $subCategoryExpenses_current = \App\Models\Expense::where(
                                                    'expense_sub_category_id',
                                                    $record->id,
                                                )
                                                    ->whereYear('date', $this->year)
                                                    ->whereMonth('date', $this->month)
                                                    ->sum('total_expense');
                                                $subCategoryExpenses_previous = \App\Models\Expense::where(
                                                    'expense_sub_category_id',
                                                    $record->id,
                                                )
                                                    ->whereYear('date', $this->year)
                                                    ->whereMonth('date', $this->month - 1)
                                                    ->sum('total_expense');
                                                $totalCategoryExpenses_current += $subCategoryExpenses_current;
                                                $totalCategoryExpenses_previous += $subCategoryExpenses_previous;

                                                $grandTotalExpenses_current += $subCategoryExpenses_current;
                                                $grandTotalExpenses_previous += $totalCategoryExpenses_previous;

                                                $increase_decrease =
                                                    $subCategoryExpenses_current - $subCategoryExpenses_previous;

                                                $total_increase_decrease += $increase_decrease;

                                            @endphp

                                            <tr>
                                                <td class="border text-left text-sm  text-gray-700 uppercase px-3 ">
                                                    {{ $record->name }}
                                                </td>
                                                <td class="border text-right text-sm text-gray-700  px-3 ">
                                                    &#8369;{{ number_format($subCategoryExpenses_current, 2) }}

                                                </td>
                                                <td class="border text-right text-sm text-gray-700  px-3 ">
                                                    &#8369;{{ number_format($subCategoryExpenses_previous, 2) }}

                                                </td>
                                                <td class="border text-right  text-sm text-gray-700  px-3 ">
                                                    &#8369;
                                                    {{ number_format($increase_decrease, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td class="border text-left text-sm uppercase font-bold  text-gray-700  px-3 ">
                                                TOTAL {{ $item->name }}
                                            </td>
                                            <td class="border text-right text-sm font-semibold text-gray-700  px-3 ">
                                                &#8369;{{ number_format($totalCategoryExpenses_current, 2) }}
                                            </td>
                                            <td class="border text-right text-sm font-semibold text-gray-700  px-3 ">
                                                &#8369;{{ number_format($totalCategoryExpenses_previous, 2) }}
                                            </td>
                                            <td class="border text-right text-sm text-gray-700  px-3 ">
                                                &#8369;
                                                {{ number_format($totalCategoryExpenses_current - $totalCategoryExpenses_previous, 2) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endforeach

                        <div class=" grid grid-cols-3">
                            <div class="">
                                <table id="example" class="table-auto  w-full">
                                    <thead class="font-normal">
                                        <tr>
                                            <th class=" text-center px-2 uppercase text-sm font-semibold text-white py-1">
                                                CURRENT MONTHY ({{ $month_name }})
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td
                                                class="border text-left text-xs py-[0.30rem] font-semibold text-gray-700  px-3 ">
                                                TOTAL CASH PAYMENTS (COGS + OC + ADDITIONAL EXPENSES)
                                            </td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-span-2">
                                <table id="example" class="table-auto  w-full">
                                    <thead class="font-normal">
                                        <tr>
                                            <th class="text-center px-2 uppercase text-sm font-semibold text-white py-1">
                                                CURRENT MONTHY ({{ $month_name }})
                                            </th>
                                            <th class="text-center px-2 text-sm uppercase font-semibold text-white py-1">
                                                PREVIOUS MONTH ({{ $previous_month_name }})
                                            </th>
                                            <th class="text-center px-2 text-sm font-semibold text-white py-1">
                                                INCREASE (or DECREASE)
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="border text-right font-semibold text-gray-700  px-3 ">
                                                &#8369;{{ number_format($grandTotalExpenses_current, 2) }}
                                            </td>
                                            <td class="border text-right font-semibold text-gray-700  px-3 ">
                                                &#8369;{{ number_format($grandTotalExpenses_previous, 2) }}
                                            </td>
                                            <td class="border text-right font-semibold text-gray-700  px-3 ">
                                                &#8369;{{ number_format($total_increase_decrease, 2) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class=" grid grid-cols-3">
                            <div class="">
                                <table id="example" class="table-auto  w-full">
                                    <thead class="font-normal">
                                        <tr>
                                            <th class=" text-center px-2 uppercase text-sm font-semibold text-white py-1">
                                                CURRENT MONTHY ({{ $month_name }})
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td
                                                class="border text-left text-xs py-[0.30rem] font-semibold text-gray-700  px-3 ">
                                                NET CASH CHANGE
                                                ( CASH RECEIPTS – CASH PAYMENTS )

                                            </td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-span-2">
                                <table id="example" class="table-auto  w-full">
                                    <thead class="font-normal">
                                        <tr>
                                            <th class="text-center px-2 uppercase text-sm font-semibold text-white py-1">
                                                CURRENT MONTHY ({{ $month_name }})
                                            </th>
                                            <th class="text-center px-2 text-sm uppercase font-semibold text-white py-1">
                                                PREVIOUS MONTH ({{ $previous_month_name }})
                                            </th>
                                            <th class="text-center px-2 text-sm font-semibold text-white py-1">
                                                INCREASE (or DECREASE)
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="border text-right text-gray-700  px-3 ">
                                                &#8369;
                                                {{ number_format($current_sales - $grandTotalExpenses_current, 2) }}
                                            </td>
                                            <td class="border text-right text-gray-700  px-3 ">
                                                &#8369;
                                                {{ number_format($previous_sales - $grandTotalExpenses_previous, 2) }}
                                            </td>
                                            <td class="border text-right text-gray-700  px-3 ">
                                                &#8369;
                                                {{ number_format($current_sales - $grandTotalExpenses_current - ($previous_sales - $grandTotalExpenses_previous), 2) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class=" grid grid-cols-3">
                            <div class="">
                                <table id="example" class="table-auto  w-full">
                                    <thead class="font-normal">
                                        <tr>
                                            <th class=" text-center px-2 uppercase text-sm font-semibold text-white py-1">
                                                CURRENT MONTHY ({{ $month_name }})
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td
                                                class="border text-left text-xs py-[0.30rem] font-semibold text-gray-700  px-3 ">
                                                MONTH ENDING CASH POSITION
                                                ( CASH ON HAND + CASH RECEIPTS – CASH PAYMENTS )


                                            </td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-span-2">
                                <table id="example" class="table-auto  w-full">
                                    <thead class="font-normal">
                                        <tr>
                                            <th class="text-center px-2 uppercase text-sm font-semibold text-white py-1">
                                                CURRENT MONTHY ({{ $month_name }})
                                            </th>
                                            <th class="text-center px-2 text-sm uppercase font-semibold text-white py-1">
                                                PREVIOUS MONTH ({{ $previous_month_name }})
                                            </th>
                                            <th class="text-center px-2 text-sm font-semibold text-white py-1">
                                                INCREASE (or DECREASE)
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="border text-right text-gray-700  px-3 py-[0.6rem]">
                                                &#8369;{{ number_format($current_begin_cashflow + ($current_end_cashflow - $grandTotalExpenses_current), 2) }}
                                            </td>
                                            <td class="border text-right text-gray-700  px-3 py-[0.6rem]">
                                                &#8369;{{ number_format($previous_begin_cashflow + ($previous_end_cashflow - $grandTotalExpenses_previous), 2) }}
                                            </td>
                                            <td class="border text-right text-gray-700  px-3 py-[0.6rem]">
                                                &#8369;
                                                {{ number_format($current_begin_cashflow + ($current_end_cashflow - $grandTotalExpenses_current) - ($previous_begin_cashflow + ($previous_end_cashflow - $grandTotalExpenses_previous)), 2) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5">
                        <x-button label="PRINT REPORT" @click="printOut($refs.printContainer.outerHTML);"
                            class="font-semibold" wire:click="cashflowReport" icon="printer" dark />
                    </div>
                @break

                @default
            @endswitch
        @endif
    </div>
</div>
