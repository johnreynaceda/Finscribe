<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function expenses(){
        return $this->hasMany(Expense::class);
    }

    public function budgetCategories(){
        return $this->hasMany(BudgetCategory::class);
    }

    public function expenseSubCategories(){
        return $this->hasMany(ExpenseSubCategory::class);
    }
}
