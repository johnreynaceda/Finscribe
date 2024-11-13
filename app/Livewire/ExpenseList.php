<?php

namespace App\Livewire;

use App\Events\ReceivedNotification;
use App\Mail\RejectAccount;
use App\Mail\UserStatus;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\ExpenseSubCategory;
use App\Models\LogHistory;
use App\Models\Shop\Product;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
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
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Flasher\SweetAlert\Prime\SweetAlertInterface;
use WireUi\Traits\Actions;
class ExpenseList extends Component implements HasForms, HasTable
{
    use Actions;
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(Expense::query())->headerActions([
                CreateAction::make('new_expense')->action(
                    function($record, $data){
                        Expense::create([
                            'expense_sub_category_id' => $data['expense_sub_category_id'],
                            'people_in_charge' => $data['people_in_charge'],
                            'total_expense' => $data['total_expense'],
                            'notes' => $data['notes'],
                            'user_id' => auth()->user()->id,
                            'date' => Carbon::parse($data['date']),
                        ]);
                        LogHistory::create([
                            'user_id' => auth()->user()->id,
                            'action' => 'CREATE EXPENSE REPORT',
                        ]);

                        sweetalert()->success('Added Successfully');

                        \App\Models\Notification::create([
                            'uploaded_by' => auth()->user()->user_type,
                            'details' => auth()->user()->user_type.'_'.auth()->user()->name.' has create a expense report',
                        ]);


                        $this->notification()->success(
                            $title = 'Notification',
                            $description = auth()->user()->user_type.'_'.auth()->user()->name.' has create a expense report.',
                        );


                        $message = auth()->user()->user_type.'_'.auth()->user()->name.' has create a expense report';

                        // broadcast(new ReceivedNotification());
                        ReceivedNotification::dispatch($message,auth()->user()->user_type);
                    }
                )->form([
                    Select::make('expense_sub_category_id')->label('Expense Account')->searchable()->options(
                        ExpenseSubCategory::all()->mapWithKeys(function($record){
                            return [$record->id => $record->name];
                        }),
                    )->required(),
                    TextInput::make('people_in_charge')->required(),
                    TextInput::make('total_expense')->numeric()->required(),
                    Textarea::make('notes'),
                    DatePicker::make('date')->required()
                    // Textarea::make('notes'),

                ])->modalWidth('xl')->createAnother(false)
            ])
            ->columns([
                TextColumn::make('expenseSubCategory.name')->label('CATEGORY NAME'),
                TextColumn::make('people_in_charge')->label('PEOPLE IN CHARGE'),
                TextColumn::make('total_expense')->label('TOTAL EXPENSES')->formatStateUsing(
                    function($record){
                        return '₱'.number_format($record->total_expense,2);
                    }
                ),
                TextColumn::make('notes')->label('NOTES'),
                TextColumn::make('date')->date()->label('DATE'),
                TextColumn::make('user.name')->label('CREATED BY'),

            ])
            ->filters([
                Filter::make('date')
                ->form([
                    DatePicker::make('date_from'),
                    DatePicker::make('date_to'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['date_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('date', '>=', $date),
                        )
                        ->when(
                            $data['date_to'],
                            fn (Builder $query, $date): Builder => $query->whereDate('date', '<=', $date),
                        );
                })
            ])
            ->actions([
               EditAction::make('edit')->color('success')->action(
                function($record, $data){
                    $record->update([
                        'expense_sub_category_id' => $data['expense_sub_category_id'],
                        'people_in_charge' => $data['people_in_charge'],
                        'total_expense' => $data['total_expense'],
                        'notes' => $data['notes'],
                        'date' => Carbon::parse($data['date']),
                    ]);
                    LogHistory::create([
                        'user_id' => auth()->user()->id,
                        'action' => 'UPDATE EXPENSE REPORT',
                    ]);
                    sweetalert()->success('Updated Successfully');
                }
               )->form([
                Select::make('expense_sub_category_id')->label('Expense Account')->searchable()->options(
                    ExpenseSubCategory::all()->mapWithKeys(function($record){
                        return [$record->id => $record->expenseCategory->name.' - '.$record->name];
                    }),
                )->required(),
                TextInput::make('people_in_charge')->required(),
                TextInput::make('total_expense')->numeric()->required(),
                Textarea::make('notes'),
                DatePicker::make('date')->required()
               ]),
               DeleteAction::make('delete')->action(
                function($record, $data){
                    $record->delete();
                    LogHistory::create([
                        'user_id' => auth()->user()->id,
                        'action' => 'DELETE EXPENSE REPORT',
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
        return view('livewire.expense-list');
    }
}
