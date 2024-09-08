<?php

namespace App\Livewire;

use App\Models\Expense;
use App\Models\Income;
use Carbon\Carbon;
use Livewire\Component;

class AdminDescriptive extends Component
{
    public $date_from, $date_to;

    public $revenue, $expense, $budget, $beginning, $end, $income;



    public function render()
    {

        if ($this->date_from && $this->date_to) {
            $this->income = Income::whereBetween('date', [$this->date_from, $this->date_to])->sum('total_sales');

        // Calculate total expenses for the week
        $this->expense = Expense::when(
            $this->date_from && $this->date_to, function($record){
               $record->whereBetween('date', [$this->date_from, $this->date_to]);
            }
        )->sum('total_expense');

        $from = Carbon::parse($this->date_from)->subMonth();
        $to = Carbon::parse($this->date_to)->subMonth();
        $b_income = Income::whereBetween('date', [$from, $to])->sum('total_sales');
        $b_expense = Expense::when(
            $this->date_from && $this->date_to, function($record) use ($from, $to){
               $record->whereBetween('date', [$from, $to]);
            }
        )->sum('total_expense');

        $this->beginning = $b_income - $b_expense;

        // Calculate revenue
        $this->revenue = $this->income - $this->expense;
        }else{

            $this->income = Income::whereMonth('date', now()->month)->sum('total_sales');

            // Calculate total expenses for the week
            $this->expense = Expense::whereMonth('date', now()->month)->sum('total_expense');

            $from = Carbon::parse(now())->subMonth();
            $to = Carbon::parse(now())->subMonth();

            $b_income = Income::whereMonth('date', now()->month)->sum('total_sales');
            $b_expense = Expense::whereMonth('date', now()->month)->sum('total_expense');

            $this->beginning = $b_income - $b_expense;

            // Calculate revenue
            $this->revenue = $this->income - $this->expense;
        }

        return view('livewire.admin-descriptive');
    }
}
