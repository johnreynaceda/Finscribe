<?php

namespace App\Livewire\Stakeholder;

use App\Mail\RejectAccount;
use App\Mail\UserStatus;
use App\Models\Shop\Product;
use App\Models\User;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class UserRequest extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(User::query()->where('user_type', 'Employee')->where('account_status', '!=', 'rejected'))
            ->columns([
                TextColumn::make('name')->label('FULLNAME'),
                TextColumn::make('email')->label('EMAIL'),
                TextColumn::make('userInformation.contact')->label('PHONE NUMBER'),
                TextColumn::make('userInformation.birthdate')->date()->label('BIRTHDATE'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                Action::make('approve')->label('Approve')->icon('heroicon-s-hand-thumb-up')->color('success')->action(
                    function($record){
                        $record->update([
                            'status' => true,
                        ]);
                        Mail::to($record->email)->send(new UserStatus($record->name));
                    }
                ),
                Action::make('reject')->label('Reject')->icon('heroicon-s-hand-thumb-down')->color('danger')->action(
                    function($record){
                        $record->update([
                            'status' => 0,
                            'account_status' => 'rejected',
                        ]);
                        Mail::to($record->email)->send(new RejectAccount($record->name));
                    }
                ),
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function emailSend(){
       Mail::to('johnreynaceda10@gmail.com')->send(new UserStatus('Jane Doe'));
    }

    public function render()
    {
        return view('livewire.stakeholder.user-request');
    }
}
