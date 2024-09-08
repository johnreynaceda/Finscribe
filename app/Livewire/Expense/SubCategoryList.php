<?php

namespace App\Livewire\Expense;

use App\Mail\RejectAccount;
use App\Mail\UserStatus;
use App\Models\ExpenseCategory;
use App\Models\ExpenseSubCategory;
use App\Models\LogHistory;
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
use Flasher\SweetAlert\Prime\SweetAlertInterface;

class SubCategoryList extends Component implements HasForms, HasTable
{
       use InteractsWithTable;
    use InteractsWithForms;


    public function table(Table $table): Table
    {
        return $table
            ->query(ExpenseSubCategory::query())->headerActions([
                CreateAction::make('new_sub_category')->label('New Sub Category')->action(
                    function($record, $data){
                        ExpenseSubCategory::create([
                            'expense_category_id' => $data['expense_category_id'],
                            'name' => $data['name'],
                        ]);
                        LogHistory::create([
                            'user_id' => auth()->user()->id,
                            'action' => 'CREATE EXPENSE SUB CATEGORY',
                        ]);
                        sweetalert()->success('Added Successfully');
                    }
                )->form([
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
               EditAction::make('edit')->color('success')->action(
                 function($record, $data){
                        $record->update([
                           'expense_category_id' => $data['expense_category_id'],
                           'name' => $data['name'],
                        ]);
                        LogHistory::create([
                            'user_id' => auth()->user()->id,
                            'action' => 'UPDATE EXPENSE SUB CATEGORY',
                        ]);
                        sweetalert()->success('Updated Successfully');
                    }
                )->form([
                Select::make('expense_category_id')->label('Expense Category')->options(ExpenseCategory::all()->pluck('name', 'id'))->required(),
                TextInput::make('name')->required(),
               ])->modalWidth('xl'),
               DeleteAction::make('delete')->action(
                 function($record, $data){
                        $record->delete();
                        LogHistory::create([
                            'user_id' => auth()->user()->id,
                            'action' => 'DELETE EXPENSE SUB CATEGORY',
                        ]);
                        sweetalert()->success('Deleted Successfully');
                    }

               )
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
