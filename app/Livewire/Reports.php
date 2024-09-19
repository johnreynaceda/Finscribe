<?php

namespace App\Livewire;

use App\Events\ReceivedNotification;
use App\Models\BudgetCategory;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Income;
use App\Models\LogHistory;
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

    public function incomeReport(){
        LogHistory::create([
            'user_id' => auth()->id(),
            'action' => 'PRINT INCOME REPORT',
        ]);

        \App\Models\Notification::create([
            'uploaded_by' => auth()->user()->user_type,
            'details' => auth()->user()->user_type.'_'.auth()->user()->name.' has print a income report.',
        ]);





        $message = auth()->user()->user_type.'_'.auth()->user()->name.' has print a income report.';

        // broadcast(new ReceivedNotification());
        ReceivedNotification::dispatch($message,auth()->user()->user_type);
    }

    public function budgetReport(){
        LogHistory::create([
            'user_id' => auth()->id(),
            'action' => 'PRINT BUDGET REPORT',
        ]);

        \App\Models\Notification::create([
            'uploaded_by' => auth()->user()->user_type,
            'details' => auth()->user()->user_type.'_'.auth()->user()->name.' has print a budget report.',
        ]);





        $message = auth()->user()->user_type.'_'.auth()->user()->name.' has print a budget report.';

        // broadcast(new ReceivedNotification());
        ReceivedNotification::dispatch($message,auth()->user()->user_type);
    }
    public function cashflowReport(){
        LogHistory::create([
            'user_id' => auth()->id(),
            'action' => 'PRINT CASH FLOW REPORT',
        ]);

        \App\Models\Notification::create([
            'uploaded_by' => auth()->user()->user_type,
            'details' => auth()->user()->user_type.'_'.auth()->user()->name.' has print a cash flow report.',
        ]);





        $message = auth()->user()->user_type.'_'.auth()->user()->name.' has print a cash flow report.';

        // broadcast(new ReceivedNotification());
        ReceivedNotification::dispatch($message,auth()->user()->user_type);
    }
}
