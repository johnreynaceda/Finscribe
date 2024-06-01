<?php

namespace App\Livewire\Expense;

use App\Mail\RejectAccount;
use App\Mail\UserStatus;
use App\Models\ExpenseCategory;
use App\Models\ExpenseSubCategory;
use App\Models\Shop\Product;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class SubCategoryList extends Component implements HasForms, HasTable
{
       use InteractsWithTable;
    use InteractsWithForms;


    public function table(Table $table): Table
    {
        return $table
            ->query(ExpenseSubCategory::query())->headerActions([
                CreateAction::make('new_sub_category')->label('New Sub Category')->form([
                    Select::make('expense_category_id')->label('Expense Category')->options(ExpenseCategory::all()->pluck('name', 'id'))->required(),
                    TextInput::make('name')->required(),
                ])->modalWidth('xl')
            ])
            ->columns([
                TextColumn::make('name')->label('NAME'),
                TextColumn::make('expenseCategory.name')->label('CATEGORY'),

            ])
            ->filters([
                // ...
            ])
            ->actions([
               EditAction::make('edit')->color('success')->form([
                Select::make('expense_category_id')->label('Expense Category')->options(ExpenseCategory::all()->pluck('name', 'id'))->required(),
                TextInput::make('name')->required(),
               ])->modalWidth('xl'),
               DeleteAction::make('delete')
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.expense.sub-category-list');
    }
}
