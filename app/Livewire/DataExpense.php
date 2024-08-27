<?php

namespace App\Livewire;

use App\Models\ExpenseCategory;
use App\Models\Income;
use Livewire\Component;

class DataExpense extends Component
{
    public $month, $year;
    public function render()
    {
        return view('livewire.data-expense',[
            'expenses' => ExpenseCategory::all(),
            'years' => Income::all()->pluck('date')->map(function ($date) {
                return date('Y', strtotime($date)); // Extract the year from each date
            })->unique(),
        ]);
    }
}
