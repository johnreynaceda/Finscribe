<?php

namespace App\Livewire;

use App\Events\ReceivedNotification;
use App\Mail\RejectAccount;
use App\Mail\UserStatus;
use App\Models\BudgetCategory;
use App\Models\ExpenseCategory;
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


class BudgetCategoryList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(BudgetCategory::query())->headerActions([
                CreateAction::make('new_category')->action(
                    function($record, $data){
                        BudgetCategory::create([
                            'expense_category_id' => $data['expense_category_id'],
                            'amount' => $data['amount'],
                        ]);
                        LogHistory::create([
                            'user_id' => auth()->user()->id,
                            'action' => 'CREATE BUDGET CATEGORY',
                        ]);

                        \App\Models\Notification::create([
                            'uploaded_by' => auth()->user()->user_type,
                            'details' => auth()->user()->user_type.'_'.auth()->user()->name.' has create a budget category',
                        ]);


                        // $this->notification()->success(
                        //     $title = 'Notification',
                        //     $description = auth()->user()->user_type.'_'.auth()->user()->name.' has create a budget category',
                        // );


                        $message = auth()->user()->user_type.'_'.auth()->user()->name.' has create a budget category';

                        // broadcast(new ReceivedNotification());
                        ReceivedNotification::dispatch($message,auth()->user()->user_type);
                    }
                )->form([
                    Select::make('expense_category_id')->label('Expense Category')->options(
                        ExpenseCategory::pluck('name', 'id'),
                    )->required()->unique(),
                    TextInput::make('amount')->label('Alloted Amount')->numeric()->required(),
                ])->modalWidth('xl')
            ])
            ->columns([
                TextColumn::make('expenseCategory.name')->label('EXPENSE NAME'),
                TextColumn::make('amount')->label('ALLOTED AMOUNT')->formatStateUsing(
                    function($record){
                        return '₱'.number_format($record->amount,2);
                    }
                ),

            ])
            ->filters([
                // ...
            ])
            ->actions([
               EditAction::make('edit')->color('success')->action(
                function($record, $data){
                    $record->update([
                        'expense_category_id' => $data['expense_category_id'],
                        'amount' => $data['amount'],
                    ]);
                    LogHistory::create([
                        'user_id' => auth()->user()->id,
                        'action' => 'UPDATE BUDGET CATEGORY',
                    ]);

                    \App\Models\Notification::create([
                        'uploaded_by' => auth()->user()->user_type,
                        'details' => auth()->user()->user_type.'_'.auth()->user()->name.' has update a budget category',
                    ]);





                    $message = auth()->user()->user_type.'_'.auth()->user()->name.' has update a budget category';

                    // broadcast(new ReceivedNotification());
                    ReceivedNotification::dispatch($message,auth()->user()->user_type);

                }
               )->form([
                Select::make('expense_category_id')->label('Expense Category')->options(
                    ExpenseCategory::pluck('name', 'id'),
                )->required(),
                TextInput::make('amount')->label('Alloted Amount')->numeric()->required(),
               ]),
               DeleteAction::make('delete')->action(
                function($record){
                    $record->delete();
                    LogHistory::create([
                        'user_id' => auth()->user()->id,
                        'action' => 'DELETE BUDGET CATEGORY',
                    ]);

                    \App\Models\Notification::create([
                        'uploaded_by' => auth()->user()->user_type,
                        'details' => auth()->user()->user_type.'_'.auth()->user()->name.' has delete a budget category.',
                    ]);





                    $message = auth()->user()->user_type.'_'.auth()->user()->name.' has delete a budget category.';

                    // broadcast(new ReceivedNotification());
                    ReceivedNotification::dispatch($message,auth()->user()->user_type);
                }
               )
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.budget-category-list');
    }
}
