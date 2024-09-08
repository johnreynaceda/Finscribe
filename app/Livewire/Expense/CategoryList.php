<?php

namespace App\Livewire\Expense;

use App\Mail\RejectAccount;
use App\Mail\UserStatus;
use App\Models\ExpenseCategory;
use App\Models\LogHistory;
use App\Models\Shop\Product;
use App\Models\User;
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

class CategoryList extends Component implements HasForms, HasTable
{

    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(ExpenseCategory::query())->headerActions([
                CreateAction::make('new_category')->action(
                    function($data){
                        ExpenseCategory::create([
                            'name' => $data['name'],
                        ]);
                        LogHistory::create([
                            'user_id' => auth()->user()->id,
                            'action' => 'CREATE EXPENSE CATEGORY',
                        ]);
                        sweetalert()->success('Added Successfully');
                    }
                )->form([
                    TextInput::make('name')->required(),
                ])->modalWidth('xl')
            ])
            ->columns([
                TextColumn::make('name')->label('NAME'),

            ])
            ->filters([
                // ...
            ])
            ->actions([
               EditAction::make('edit')->color('success')->action(
                function($record, $data){
                        $record->update([
                           'name' => $data['name'],
                        ]);
                        LogHistory::create([
                            'user_id' => auth()->user()->id,
                            'action' => 'EDIT EXPENSE CATEGORY',
                        ]);
                        sweetalert()->success('Updated Successfully');
                    }
                )->form([
                TextInput::make('name')->required(),
               ]),
               DeleteAction::make('delete')->action(
                function($record){
                        $record->delete();
                        LogHistory::create([
                            'user_id' => auth()->user()->id,
                            'action' => 'DELETE EXPENSE CATEGORY',
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
        return view('livewire.expense.category-list');
    }
}
