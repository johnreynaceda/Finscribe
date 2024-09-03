<?php

namespace App\Livewire;

use App\Models\Expense;
use App\Models\Income;
use Livewire\Attributes\On;
use Livewire\Component;

class DescriptiveAnalytic extends Component
{

    public $labels = [];
    public $revenue = [];
    public $budget = [];

    public $year;

    public function mount(){


        for ($i = 1; $i <= 12; $i++) {
            $this->labels[] = date('F', mktime(0, 0, 0, $i, 10)); // Generates the full month name

            $income = Income::whereMonth('date', $i)->whereYear('date', now()->year - 1)->sum('total_sales');
            $expense = Expense::whereMonth('date', $i)->whereYear('date', now()->year - 1)->sum('total_expense');

            $this->revenue[] = $income - $expense;
            $this->budget[] = (75 / 100) * ($income - $expense);
        }

        // dd($this->revenue);

    }

    public function calculateBudget($income, $expense)
{
    // Example calculation: return 80% of income as budget
    return $income * 0.8;
}

    public function render()
    {
        return view('livewire.descriptive-analytic',[
            'years' => Income::all()->pluck('date')->map(function ($date) {
                return date('Y', strtotime($date)); // Extract the year from each date
            })->unique(),
        ]);
    }
}
