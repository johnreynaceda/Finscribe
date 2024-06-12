<?php

namespace App\Livewire;

use App\Imports\IncomeImport;
use App\Mail\RejectAccount;
use App\Mail\UserStatus;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Income;
use App\Models\IncomeUpload;
use App\Models\Shop\Product;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Maatwebsite\Excel\Excel;
use Flasher\SweetAlert\Prime\SweetAlertInterface;

class IncomeList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $upload = [];
    public $file;

    public function table(Table $table): Table
    {
        return $table
            ->query(Income::query())->headerActions([
                CreateAction::make('upload_income')->label('Upload Income')->icon('heroicon-o-document-text')->action(
                    function($data){


                        foreach ($this->upload as $key => $value) {
                            $this->file = $value;
                        }

                              if (IncomeUpload::where('filename', $this->file->getClientOriginalName())->count() > 0) {
                            sweetalert()->error('The file has already been uploaded');
                         }else{
                            IncomeUpload::create([
                                'filename' => $this->file->getClientOriginalName(),
                            ]);
                            \Maatwebsite\Excel\Facades\Excel::import(new IncomeImport,$this->file);
                            sweetalert()->success('Uploaded Successfully');
                         }
                    }
                )->form([
                    ViewField::make('upload')
                    ->view('filament.forms.file_upload')
                ])->modalWidth('xl')->modalSubmitActionLabel('Upload')
            ])
            ->columns([
                TextColumn::make('date')->date()->label('DATE')->alignRight(),
                TextColumn::make('total_sales')->label('TOTAL SALES')->formatStateUsing(
                    function($record){
                        return '₱'.number_format($record->total_sales,2);
                    }
                )->alignRight()->summarize(Sum::make()->label('TOTAL')),
                TextColumn::make('total_discount')->label('TOTAL DISCOUNTS')->formatStateUsing(
                    function($record){
                        return $record->discount.'%';
                    }
                )->alignRight(),
                TextColumn::make('discount')->label('DISCOUNT')->alignRight()->formatStateUsing(
                    function($record){
                        return $record->discount.'%';
                    }
                ),
                TextColumn::make('tax')->label('TAX')->alignRight()->formatStateUsing(
                    function($record){
                        return '₱'.number_format($record->tax,2);
                    }
                ),
                TextColumn::make('gross_profit')->label('GROSS PROFIT')->formatStateUsing(
                    function($record){
                        return '₱'.number_format($record->gross_profit,2);
                    }
                )->alignRight(),
                TextColumn::make('gross_profit_percentage')->label('GROSS PROFIT PERCENTAGE')->formatStateUsing(
                    function($record){
                        return $record->gross_profit_percentage.'%';
                    }
                )->alignRight(),
                TextColumn::make('total_sales_returned')->label('TOTAL SALES RETURNED')->formatStateUsing(
                    function($record){
                        return '₱'.number_format($record->total_sales_returned,2);
                    }
                )->alignRight(),
                TextColumn::make('net_sales')->label('NET SALES')->formatStateUsing(
                    function($record){
                        return '₱'.number_format($record->net_sales,2);
                    }
                )->alignRight(),
                TextColumn::make('average_net_sales')->label('AVERAGE NET SALES')->formatStateUsing(
                    function($record){
                        return '₱'.number_format($record->average_net_sales,2);
                    }
                )->alignRight(),

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

            ])
            ->bulkActions([
                BulkAction::make('delete')
                ->requiresConfirmation()
                ->action(fn (Collection $records) => $records->each->delete())
            ]);
    }

    public function render()
    {
        return view('livewire.income-list');
    }
}
