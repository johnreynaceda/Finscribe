<div>
    <div class="p-5 bg-white rounded-xl">
        <div class=" flex justify-between items-center">

            <div class="flex space-x-3 mb-5">
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

        <div class="grid grid-cols-4 gap-7">
            <div class="col-span-3">
                <h1 class="text-red-600 text-xl font-bold">EXPENSES</h1>
            </div>
            <div>
                <h1 class="text-blue-600 text-xl font-bold">BUDGET</h1>
            </div>
            @foreach ($expenses as $item)
                <div class="col-span-3">
                    <h1 class="text-gray-600 font-semibold text-xl uppercase">{{ $item->name }}</h1>

                    <ul class="mt-5 space-y-2">
                        @foreach (\App\Models\ExpenseSubCategory::whereHas('expenses', function ($query) use ($item) {
        $query->whereYear('date', $this->year)->whereMonth('date', $this->month)->where('total_expense', '>', 0);
    })->where('expense_category_id', $item->id)->get() as $record)
                            @php
                                $subCategoryExpenses = $record->expenses->sum('total_expense');
                                $budgetAmount = $item->budgetCategories->first()->amount;
                                $percentage = $budgetAmount > 0 ? ($subCategoryExpenses / $budgetAmount) * 100 : 0;
                            @endphp
                            <li class="">
                                <div class="flex justify-between">
                                    <span>{{ $record->name }}</span>
                                    <span>&#8369;{{ number_format($subCategoryExpenses, 2) }}</span>
                                </div>
                                <div class="flex w-full h-1.5 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700"
                                    role="progressbar" aria-valuenow="{{ $percentage }}" aria-valuemin="0"
                                    aria-valuemax="100">
                                    <div class="flex flex-col justify-center rounded-full overflow-hidden bg-blue-600 text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-blue-500"
                                        style="width: {{ min($percentage, 100) }}%"></div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h1 class="text-blue-600 font-semibold text-xl uppercase">
                        &#8369;{{ number_format($item->budgetCategories->first()->amount, 2) }}</h1>
                </div>
            @endforeach
        </div>

    </div>
</div>
