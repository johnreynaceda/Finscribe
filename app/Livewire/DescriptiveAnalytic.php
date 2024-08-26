<?php

namespace App\Livewire;

use App\Models\Expense;
use App\Models\Income;
use Livewire\Attributes\On;
use Livewire\Component;

class DescriptiveAnalytic extends Component
{
    public $month;
    public $year;
    public $income = 0;
    public $expense = 0;
    public $incomeTransactions = 0;
    public $budget = 0;


    public $chartValues = [];



    #[On('updateChart')]
    public function handleupdateChart(){
       $this->generateDateList();
        if ($this->month && $this->year) {
           $this->loadData();
        }
    }


    public function mount()
    {
        $this->loadData();
    }

    public function generateDateList()
    {
        if ($this->month && $this->year) {
            $this->dispatch('updateChart');
        }
    }

    public function loadData()
    {
        $this->chartValues = [0,0,0,0];
        $this->income = Income::whereYear('date', $this->year)->whereMonth('date', ($this->month-1))->sum('total_sales');

    // Calculate total expenses for the week
    $this->expense = Expense::when(
        $this->month, function($record){
           $record->whereYear('date', $this->year)->whereMonth('date', ($this->month-1));
        }
    )->sum('total_expense');

    $this->incomeTransactions = Income::whereYear('date', $this->year)->whereMonth('date', ($this->month - 1))->count();

        $this->budget = (75 / 100) * ($this->income - $this->expense);

    $this->chartValues = [$this->income - $this->expense, $this->budget];

    }

    public function render()
    {

        $this->generateDateList();
        if ($this->month && $this->year) {
           $this->loadData();
        }
        return view('livewire.descriptive-analytic',[
            'years' => Income::all()->pluck('date')->map(function ($date) {
                return date('Y', strtotime($date)); // Extract the year from each date
            })->unique(),
        ]);
    }
}
