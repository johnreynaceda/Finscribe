<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetCategory extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function expenseCategory(){
        return $this->belongsTo(ExpenseCategory::class);
    }
}
