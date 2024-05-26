<?php

namespace App\Livewire;

use App\Models\Expense;
use App\Models\Income;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DataDashboard extends Component
{
    public $month, $year;
    public $dataThisWeek = [], $dataLastWeek = [], $labels = [];

    public $income = [], $expense = [], $revenue = [];

    public function mount()
    {
        $labels = [];
        $dataThisWeek = [];
        $dataLastWeek = [];

        $today = Carbon::now();

        // Calculate the start and end of this week
        $startOfThisWeek = $today->startOfWeek();
        $endOfThisWeek = $startOfThisWeek->copy()->endOfWeek();

        // Calculate the start and end of last week
        $startOfLastWeek = $startOfThisWeek->copy()->subWeek();
        $endOfLastWeek = $startOfLastWeek->copy()->endOfWeek();

        // Generate labels and fetch corresponding data for each day of this week (Monday to Sunday)
        for ($i = 0; $i < 7; $i++) {
            $currentDay = $startOfThisWeek->copy()->addDays($i);
            $labels[] = $currentDay->format('D'); // Format the day as 'Mon', 'Tue', etc.

            $expenseThisWeek = Expense::whereDate('created_at', $currentDay)
                ->sum('total_expense');
            $dataThisWeek[] = $expenseThisWeek;

            $expenseLastWeek = Expense::whereDate('created_at', $startOfLastWeek->copy()->addDays($i))
                ->sum('total_expense');
            $dataLastWeek[] = $expenseLastWeek;
        }

        // Set the public properties for use in the view
        $this->labels = $labels;
        $this->dataThisWeek = $dataThisWeek;
        $this->dataLastWeek = $dataLastWeek;
    }

    public function render()
    {
        $this->income = Income::whereYear('date', $this->year)->whereMonth('date', $this->month)->sum('total_sales');

    // Calculate total expenses for the week
    $this->expense = Expense::when(
        $this->month, function($record){
           $record->whereYear('date', $this->year)->whereMonth('date', $this->month);
        }
    )->sum('total_expense');

    // Calculate revenue
    $this->revenue = $this->income - $this->expense;


        return view('livewire.data-dashboard',[
            'years' => Income::all()->pluck('date')->map(function ($date) {
                return date('Y', strtotime($date)); // Extract the year from each date
            })->unique(),
        ]);
    }


}
