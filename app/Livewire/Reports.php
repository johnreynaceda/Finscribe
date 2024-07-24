<?php

namespace App\Livewire;

use App\Models\BudgetCategory;
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
    public $previous_month_name;

    //budget
    public $budgets;

    public $datas;
    public $spents;
    public $budget_expenses;



    public function  updatedMonth(){
        $this->month_name = Carbon::createFromDate($this->year, $this->month, 1)->format('F');
        $this->previous_month_name = Carbon::createFromDate($this->year, ($this->month - 1), 1)->format('F');
        $this->first_day = Carbon::createFromDate($this->year, $this->month, 1)->startOfMonth()->format('d');
        $this->last_day = Carbon::createFromDate($this->year, $this->month, 1)->endOfMonth()->format('d');

    }


    public function render()
    {
        if ($this->report_type == 'Cash Flow') {
            $this->datas = Income::whereYear('date', $this->year)->whereMonth('date', $this->month)->get();
        $this->spents = Expense::whereYear('date', $this->year)->whereMonth('date', $this->month)->get();
        $this->budgets = BudgetCategory::sum('amount');
        $expenseSubCategoryIds = Expense::all()->pluck('expense_sub_category_id')
        ->unique();


        $this->budget_expenses = ExpenseCategory::whereHas('expenseSubCategories', function($query) use ($expenseSubCategoryIds) {
            $query->whereIn('id', $expenseSubCategoryIds);
        })->get();

        }else{
            $expenseSubCategoryIds = Expense::whereYear('date', $this->year)
    ->whereMonth('date', $this->month)
    ->pluck('expense_sub_category_id')
    ->unique();


    $this->expenses = ExpenseCategory::whereHas('expenseSubCategories', function($query) use ($expenseSubCategoryIds) {
        $query->whereIn('id', $expenseSubCategoryIds);
    })->get();

        $this->incomes = Income::whereYear('date', $this->year)->whereMonth('date', $this->month)->get();

        $this->datas = Income::whereYear('date', $this->year)->whereMonth('date', $this->month)->get();
        $this->spents = Expense::whereYear('date', $this->year)->whereMonth('date', $this->month)->get();
        $this->budgets = BudgetCategory::sum('amount');
        $expenseSubCategoryIds = Expense::whereYear('date', $this->year)
        ->whereMonth('date', $this->month)
        ->where('total_expense', '>', 0)
        ->pluck('expense_sub_category_id')
        ->unique();


        $this->budget_expenses = ExpenseCategory::whereHas('expenseSubCategories', function($query) use ($expenseSubCategoryIds) {
            $query->whereIn('id', $expenseSubCategoryIds);
        })->get();

        $this->month_name = Carbon::createFromDate($this->year, $this->month, 1)->format('F');
        }


        return view('livewire.reports',[
            'years' => Income::all()->pluck('date')->map(function ($date) {
                return date('Y', strtotime($date)); // Extract the year from each date
            })->unique(),
        ]);
    }
}
