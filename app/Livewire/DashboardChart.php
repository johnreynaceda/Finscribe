<?php

namespace App\Livewire;

use App\Models\Expense;
use App\Models\Income;
use Livewire\Attributes\On;
use Livewire\Component;

class DashboardChart extends Component
{
    public $month, $year;
    public $income = [], $expense = [], $revenue = [];

    public $chartValues = [];
    public $labels = [];

    #[On('updateChart')]
    public function handleupdateChart(){
       $this->generateDateList();
        if ($this->month && $this->year) {
           $this->loadData();
        }
    }


    public function mount()
    {
        $this->labels = ['Expenses', 'Revenue'];
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
        $this->chartValues = [];

        if ($this->month && $this->year) {
            $this->income = Income::whereYear('date', $this->year)->whereMonth('date', $this->month)->sum('total_sales');

            // Calculate total expenses for the week
            $this->expense = Expense::when(
                $this->month, function($record){
                   $record->whereYear('date', $this->year)->whereMonth('date', $this->month);
                }
            )->sum('total_expense');
        }else{
            $this->income = Income::whereYear('date', now()->year)->whereMonth('date', now()->month)->sum('total_sales');

            // Calculate total expenses for the week
            $this->expense = Expense::whereYear('date', now()->year)->whereMonth('date', now()->month)->sum('total_expense');
        }

    // Calculate revenue
    $this->revenue = $this->income - $this->expense;

    $this->chartValues = [$this->expense,$this->revenue];

    }


    public function render()
    {
        // $this->income = Income::whereYear('date', $this->year)->whereMonth('date', $this->month)->sum('total_sales');
        // dd($this->income);
        $this->generateDateList();
        if ($this->month && $this->year) {
           $this->loadData();
        }
        return view('livewire.dashboard-chart',[
            'years' => Income::all()->pluck('date')->map(function ($date) {
                return date('Y', strtotime($date)); // Extract the year from each date
            })->unique(),
        ]);
    }
}
