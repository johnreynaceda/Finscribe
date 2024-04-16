<?php

namespace App\Livewire;

use App\Mail\RejectAccount;
use App\Mail\UserStatus;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Shop\Product;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
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

class ExpenseList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(Expense::query())->headerActions([
                CreateAction::make('new_expense')->form([
                    Select::make('expense_category_id')->label('Category')->searchable()->options(
                        ExpenseCategory::all()->pluck('name', 'id'),
                    )->required(),
                    TextInput::make('people_in_charge')->required(),
                    TextInput::make('total_expense')->numeric()->required(),
                    Textarea::make('notes')
                ])->modalWidth('xl')
            ])
            ->columns([
                TextColumn::make('expenseCategory.name')->label('CATEGORY NAME'),
                TextColumn::make('people_in_charge')->label('PEOPLE IN CHARGE'),
                TextColumn::make('total_expense')->label('TOTAL EXPENSES')->formatStateUsing(
                    function($record){
                        return '₱'.number_format($record->total_expense,2);
                    }
                ),
                TextColumn::make('note')->label('NOTES'),

            ])
            ->filters([
                // ...
            ])
            ->actions([
               EditAction::make('edit')->color('success')->form([
                TextInput::make('name')->required(),
               ]),
               DeleteAction::make('delete')
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.expense-list');
    }
}
