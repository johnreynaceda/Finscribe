<?php

namespace App\Livewire;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Income;
use Carbon\Carbon;
use Livewire\Component;

class Reports extends Component
{
    public $report_type;
    public $expenses = [], $incomes = [];
    public $year, $month, $first_day, $last_day;
    public $month_name;

    public function  updatedMonth(){
        $this->month_name = Carbon::createFromDate($this->year, $this->month, 1)->format('F');
        $this->first_day = Carbon::createFromDate($this->year, $this->month, 1)->startOfMonth()->format('d');
        $this->last_day = Carbon::createFromDate($this->year, $this->month, 1)->endOfMonth()->format('d');

    }


    public function render()
    {
        $expenseSubCategoryIds = Expense::whereYear('date', $this->year)
    ->whereMonth('date', $this->month)
    ->pluck('expense_sub_category_id')
    ->unique();


    $this->expenses = ExpenseCategory::whereHas('expenseSubCategories', function($query) use ($expenseSubCategoryIds) {
        $query->whereIn('id', $expenseSubCategoryIds);
    })->get();

        $this->incomes = Income::whereYear('date', $this->year)->whereMonth('date', $this->month)->get();

        return view('livewire.reports',[
            'years' => Income::all()->pluck('date')->map(function ($date) {
                return date('Y', strtotime($date)); // Extract the year from each date
            })->unique(),
        ]);
    }
}
