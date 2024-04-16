<?php

namespace App\Livewire;

use App\Imports\IncomeImport;
use App\Mail\RejectAccount;
use App\Mail\UserStatus;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Income;
use App\Models\Shop\Product;
use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
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
use Maatwebsite\Excel\Excel;

class IncomeList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $upload = [];


    public function table(Table $table): Table
    {
        return $table
            ->query(Income::query())->headerActions([
                CreateAction::make('upload_income')->label('Upload Income')->icon('heroicon-o-document-text')->action(
                    function($data){

                        foreach ($this->upload as $key => $value) {
                           \Maatwebsite\Excel\Facades\Excel::import(new IncomeImport,$value);
                        }
                    }
                )->form([
                    ViewField::make('upload')
                    ->view('filament.forms.file_upload')
                ])->modalWidth('xl')->modalSubmitActionLabel('Upload')
            ])
            ->columns([
                TextColumn::make('date')->date()->label('DATE'),
                TextColumn::make('total_sales')->label('TOTAL SALES')->formatStateUsing(
                    function($record){
                        return '₱'.number_format($record->total_sales,2);
                    }
                ),
                TextColumn::make('total_discount')->label('TOTAL DISCOUNTS'),
                TextColumn::make('discount')->label('DISCOUNT'),
                TextColumn::make('tax')->label('TAX'),
                TextColumn::make('gross_profit')->label('GROSS PROFIT')->formatStateUsing(
                    function($record){
                        return '₱'.number_format($record->gross_profit,2);
                    }
                ),
                TextColumn::make('gross_profit_percentage')->label('GROSS PROFIT PERCENTAGE'),
                TextColumn::make('total_sales_returned')->label('TOTAL SALES RETURNED')->formatStateUsing(
                    function($record){
                        return '₱'.number_format($record->total_sales_returned,2);
                    }
                ),
                TextColumn::make('net_sales')->label('NET SALES'),
                TextColumn::make('average_net_sales')->label('AVERAGE NET SALES'),

            ])
            ->filters([
                // ...
            ])
            ->actions([

            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.income-list');
    }
}
