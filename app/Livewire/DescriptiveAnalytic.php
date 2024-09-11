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


        $totalNetIncome = 0;  // Accumulates net income over past months
        $monthsProcessed = 0; // Keeps track of how many months have been processed

        for ($i = 1; $i <= 12; $i++) {
            // Generate the full month name
            $this->labels[] = date('F', mktime(0, 0, 0, $i, 10));

            // Fetch income and expense for the current month
            $income = Income::whereMonth('date', $i-1)
                            ->whereYear('date', now()->year)
                            ->sum('total_sales');

            $expense = Expense::whereMonth('date', $i-1)
                              ->whereYear('date', now()->year)
                              ->sum('total_expense');

            // Calculate revenue (net income) for the current month
            $netIncome = $income - $expense;

            // Update total net income with the current month's net income
            $totalNetIncome += $netIncome;
            $monthsProcessed++;

            // For current month, calculate predicted revenue based on the average of previous months' net income
            if ($monthsProcessed > 1) { // We can only predict after at least one month has data
                $predictedRevenue = $totalNetIncome / ($monthsProcessed - 1); // Exclude the current month
            } else {
                $predictedRevenue = $netIncome; // If it's the first month, use actual income as prediction
            }

            // Calculate budget as 75% of the predicted revenue
            $predictedBudget = (75 / 100) * $predictedRevenue;

            // Store the predicted revenue and budget
            $this->revenue[] = $predictedRevenue;
            $this->budget[] = $predictedBudget;
        }



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
