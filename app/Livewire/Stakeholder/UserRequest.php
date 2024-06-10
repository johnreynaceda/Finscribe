<?php

namespace App\Livewire\Stakeholder;

use App\Mail\RejectAccount;
use App\Mail\UserStatus;
use App\Models\Shop\Product;
use App\Models\User;
use App\Models\UserInformation;
use App\Notifications\CreateAccount;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use Flasher\SweetAlert\Prime\SweetAlertInterface;

class UserRequest extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(User::query())->headerActions([
                CreateAction::make('create')->label('New User')->icon('heroicon-o-user-plus')->action(
                    function($data){
                        $user = User::create([
                            'name' => $data['firstname']. ' ' . $data['lastname'],
                            'email' => $data['email'],
                            'password' => bcrypt(12345),
                            'user_type' => $data['user_type'],
                        ]);
                        UserInformation::create([
                            'user_id' => $user->id,
                            'firstname' => $data['firstname'],
                            'lastname' => $data['lastname'],
                        ]);
                        sweetalert()->success('User created successfully');
                        $user->notify(new CreateAccount($user->name));


                    }
                )->form([
                    TextInput::make('firstname')->required(),
                    TextInput::make('lastname')->required(),
                    TextInput::make('email')->required(),
                    Select::make('user_type')->options([
                        'Superadmin' => 'Superadmin',
                        'Admin' => 'Admin',
                        'Employee' => 'Employee'
                    ])
                ])->modalWidth('xl')->modalHeading('Create User')
            ])
            ->columns([
                TextColumn::make('name')->label('FULLNAME'),
                TextColumn::make('email')->label('EMAIL'),
                TextColumn::make('user_type')->label('USER TYPE'),
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

    public function emailSend(){
       Mail::to('johnreynaceda10@gmail.com')->send(new UserStatus('Jane Doe'));
    }

    public function render()
    {
        return view('livewire.stakeholder.user-request');
    }
}
