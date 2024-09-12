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
        $totalNetIncome = 0;      // Accumulates net income of previous months
$previousMonths = 0;      // Counts how many months had non-zero net income
$lastMonthNetIncome = null;  // Track the net income of the previous month

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

    // Predictive revenue calculation
    if ($i > 1) {  // For February and later months
        if ($lastMonthNetIncome === 0) {
            // If the last month's net income was 0, the current month's prediction is 0
            $predictedNetIncome = 0;
        } else if ($previousMonths > 0) {
            // Predicted net income is the average of all previous months' net income (excluding zero)
            $predictedNetIncome = $totalNetIncome / $previousMonths;
        } else {
            // If no previous months have non-zero net income, predicted net income is 0
            $predictedNetIncome = 0;
        }

        // Budget is 75% of the predicted net income
        $predictedBudget = (75 / 100) * $predictedNetIncome;
    } else {
        // For January, no previous data to predict from
        $predictedNetIncome = 0;
        $predictedBudget = 0;
    }

    // Store the predicted net income and budget for the current month
    $this->revenue[] = $predictedNetIncome;
    $this->budget[] = $predictedBudget;

    // Update total net income and previous months count only if the current month's net income is positive
    if ($netIncome > 0) {
        $totalNetIncome += $netIncome;  // Accumulate net income from previous months
        $previousMonths++;  // Count the number of months with non-zero net income
    }

    // Set the last month's net income to the current month's net income for the next loop
    $lastMonthNetIncome = $netIncome;
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
