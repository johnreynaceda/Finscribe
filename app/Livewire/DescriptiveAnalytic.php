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
    public $netIncomes = [];

    public $year;

    public function mount(){
        $totalNetIncome = 0;  // Accumulates net income over past months
        $previousNetIncome = 0; // Holds the net income of the previous month for prediction

        for ($i = 1; $i <= 12; $i++) {
            // Generate the full month name
            $this->labels[] = date('F', mktime(0, 0, 0, $i, 10));

            // Fetch income and expense for the current month
            $income = Income::whereMonth('date', $i)
                            ->whereYear('date', now()->year)
                            ->sum('total_sales');

            $expense = Expense::whereMonth('date', $i)
                              ->whereYear('date', now()->year)
                              ->sum('total_expense');

            // Calculate net income for the current month
            $netIncome = $income - $expense;

            // Store the actual net income for the current month
            $this->netIncomes[] = $netIncome;

            // For months starting from February (i > 1), use the previous month's net income as the predicted revenue
            if ($i > 1) {
                // If the previous month's net income is 0, set the predicted revenue and budget to 0 for the current month
                if ($previousNetIncome == 0) {
                    $predictedRevenue = 0;
                    $predictedBudget = 0;
                } else {
                    // Predicted revenue is the net income of the previous month
                    $predictedRevenue = $previousNetIncome;

                    // Calculate budget as 75% of the predicted revenue
                    $predictedBudget = (75 / 100) * $predictedRevenue;
                }
            } else {
                // For January, set both predicted revenue and budget to 0
                $predictedRevenue = 0;
                $predictedBudget = 0;
            }

            // Store the predicted revenue and budget for the current month
            $this->revenue[] = $predictedRevenue;
            $this->budget[] = $predictedBudget;

            // Update the previous month's net income for the next iteration
            $previousNetIncome = $netIncome;
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
