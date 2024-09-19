<?php

namespace App\Livewire;

use App\Events\ReceivedNotification;
use App\Models\BudgetCategory;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\ExpenseSubCategory;
use App\Models\Income;
use App\Models\LogHistory;
use Carbon\Carbon;
use Livewire\Component;

class BudgetingTracking extends Component
{
    public $year, $month;
    public $month_name;

    public $budgets;

    public $datas;
    public $spents;
    public $expenses;

    public function search(){
        sleep(1);
        $this->validate([
            'year' => 'required',
            'month' =>'required',
        ]);
        $this->datas = Income::whereYear('date', $this->year)->whereMonth('date', $this->month)->get();
        $this->spents = Expense::whereYear('date', $this->year)->whereMonth('date', $this->month)->get();
        $this->budgets = BudgetCategory::sum('amount');
        // dd($this->budgets);

        $expenseSubCategoryIds = Expense::whereYear('date', $this->year)
    ->whereMonth('date', $this->month)
    ->where('total_expense', '>', 0)
    ->pluck('expense_sub_category_id')
    ->unique();

    LogHistory::create([
        'user_id' => auth()->user()->id,
        'action' => 'GENERATE BUDGET TRACKING',
    ]);


    $this->expenses = ExpenseCategory::whereHas('expenseSubCategories', function($query) use ($expenseSubCategoryIds) {
        $query->whereIn('id', $expenseSubCategoryIds);
    })->get();

        $this->month_name = Carbon::createFromDate($this->year, $this->month, 1)->format('F');

        \App\Models\Notification::create([
            'uploaded_by' => auth()->user()->user_type,
            'details' => auth()->user()->user_type.'_'.auth()->user()->name.' has generate budget tracking.',
        ]);


        // $this->notification()->success(
        //     $title = 'Notification',
        //     $description = auth()->user()->user_type.'_'.auth()->user()->name.' has generate budget tracking.',
        // );


        $message = auth()->user()->user_type.'_'.auth()->user()->name.' has generate budget tracking.';

        // broadcast(new ReceivedNotification());
        ReceivedNotification::dispatch($message,auth()->user()->user_type);
    }



    public function render()
    {


        return view('livewire.budgeting-tracking',[
            'years' => Income::all()->pluck('date')->map(function ($date) {
                return date('Y', strtotime($date)); // Extract the year from each date
            })->unique(),
        ]);
    }
}
