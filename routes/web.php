<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    switch (auth()->user()->user_type) {
        case 'Stakeholder':
           return redirect()->route('stakeholder.dashboard');
            break;

        case 'Superadmin':
           return redirect()->route('superadmin.dashboard');
            break;
        case 'Admin':
            return redirect()->route('admin.dashboard');
            break;

        default:
        return redirect()->route('employee.dashboard');
            break;
    }
})->middleware(['auth', 'verified'])->name('dashboard');

//stakeholder
Route::prefix('/stakeholder')->group(
    function(){
        Route::get('/dashboard', function(){
            return view('stakeholder.index');
        })->name('stakeholder.dashboard');
        Route::get('/user', function(){
            return view('stakeholder.user-request');
        })->name('stakeholder.user-request');
        Route::get('/expense-category', function(){
            return view('stakeholder.expense.category');
        })->name('stakeholder.expense.category');
        Route::get('/expenses', function(){
            return view('stakeholder.expense.index');
        })->name('stakeholder.expense');
        Route::get('/income', function(){
            return view('stakeholder.income.index');
        })->name('stakeholder.income');
        Route::get('/income-tracking', function(){
            return view('stakeholder.income.tracking');
        })->name('stakeholder.income-tracking');
        Route::get('/expense-tracking', function(){
            return view('stakeholder.expense.tracking');
        })->name('stakeholder.expense-tracking');
        Route::get('/budgeting', function(){
            return view('stakeholder.budgeting');
        })->name('stakeholder.budgeting');
        Route::get('/reports', function(){
            return view('stakeholder.reports');
        })->name('stakeholder.reports');
    }
);

//employee
Route::prefix('/employee')->group(
    function(){

        Route::get('/dashboard', function(){
                return view('employee.index');
        })->name('employee.dashboard');
    }
);


//Superadmin
Route::prefix('/superadmin')->group(
    function(){
        Route::get('/dashboard', function(){
            return view('superadmin.index');
        })->name('superadmin.dashboard');
    }
);

//admin
Route::prefix('/admin')->group(
    function(){
        Route::get('/dashboard', function(){
            return view('admin.index');
        })->name('admin.dashboard');
    }
);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
