<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseSubCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function expenseCategory(){
        return $this->belongsTo(ExpenseCategory::class);
    }

    public function expenses(){
        return $this->hasMany(Expense::class);
    }
}
