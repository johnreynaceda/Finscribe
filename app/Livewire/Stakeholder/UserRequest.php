<?php

namespace App\Livewire\Stakeholder;

use App\Events\ReceivedNotification;
use App\Livewire\AdminDescriptive;
use App\Mail\RejectAccount;
use App\Mail\UserStatus;
use App\Models\LogHistory;
use App\Models\Shop\Product;
use App\Models\User;
use App\Models\UserInformation;
use App\Notifications\CreateAccount;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
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
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use Flasher\SweetAlert\Prime\SweetAlertInterface;
use WireUi\Traits\Actions;
class UserRequest extends Component implements HasForms, HasTable
{
    use Actions;

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
                            'contact' => $data['contact'],
                            'birthdate' => Carbon::parse($data['birthdate']),
                        ]);

                        LogHistory::create([
                            'user_id' => auth()->user()->id,
                            'action' => "CREATE USER",
                        ]);

                        \App\Models\Notification::create([
                            'uploaded_by' => auth()->user()->user_type,
                            'details' => auth()->user()->user_type.'_'.auth()->user()->name.' has created a user record',
                        ]);
                        $this->notification()->success(
                            $title = 'Notification',
                            $description = auth()->user()->user_type.'_'.auth()->user()->name.' has created a user record',
                        );


                        $message = auth()->user()->user_type.'_'.auth()->user()->name.' has created a user record';

                        // broadcast(new ReceivedNotification());
                        ReceivedNotification::dispatch($message,auth()->user()->user_type);

                        // $this->emit('refresh');


                        sweetalert()->success('User created successfully');
                        $user->notify(new CreateAccount($user->name));


                    }
                )->form([
                    Grid::make(2)->schema([
                        TextInput::make('firstname')->required(),
                    TextInput::make('lastname')->required(),
                    TextInput::make('email')->required(),
                    Select::make('user_type')->options([
                        'Superadmin' => 'Superadmin',
                        'Admin' => 'Admin',
                        'Employee' => 'Employee'
                    ]),
                    TextInput::make('contact')->required()->numeric(),
                    DatePicker::make('birthdate')
                    ])
                ])->modalWidth('xl')->modalHeading('Create User')->createAnother(false)
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
                EditAction::make('edit')->color('success')->action(
                    function($record, $data){
                        $record->update([
                           'name' => ($data['firstname'] ? $data['firstname'] : $record->UserInformation->firstname) . ' ' . ($data['lastname'] ? $data['lastname'] : $record->UserInformation->lastname),
                           'email' => $data['email'],
                           'user_type' => $data['user_type'],
                        //    'password' => bcrypt($data['password']),
                        ]);

                        $record->UserInformation->update([
                            'firstname' => $data['firstname'] ? $data['firstname'] : $record->UserInformation->firstname,
                            'lastname' => $data['lastname'] ? $data['lastname'] : $record->UserInformation->lastname,
                            'contact' => $data['contact'] ? $data['contact'] : $record->UserInformation->contact,
                            'birthdate' => $data['birthdate'] ? $data['birthdate'] : $record->UserInformation->birthdate,
                        ]);
                        LogHistory::create([
                            'user_id' => auth()->user()->id,
                            'action' => "UPDATE USER",
                        ]);
                        \App\Models\Notification::create([
                            'uploaded_by' => auth()->user()->user_type,
                            'details' => auth()->user()->user_type.'_'.auth()->user()->name.' has updated a user record',
                        ]);

                        $this->notification()->success(
                            $title = 'Notification',
                            $description = auth()->user()->user_type.'_'.auth()->user()->name.' has updated a user record',
                        );



                        $message = auth()->user()->user_type.'_'.auth()->user()->name.' has update a user record';

                        // broadcast(new ReceivedNotification());
                        ReceivedNotification::dispatch($message,auth()->user()->user_type);

                        sweetalert()->success('User updated successfully');
                    }
                )->form(
                    function($record){
                        $query = UserInformation::where('user_id', $record->id)->first();
                        return [
                            Grid::make(2)->schema([
                                TextInput::make('firstname')->placeholder($query->firstname),
                            TextInput::make('lastname')->placeholder($query->lastname),
                            TextInput::make('email')->required(),
                            Select::make('user_type')->options([
                                'Superadmin' => 'Superadmin',
                                'Admin' => 'Admin',
                                'Employee' => 'Employee'
                            ]),
                            TextInput::make('contact')->numeric()->placeholder($query->contact),
                            DatePicker::make('birthdate')->placeholder(Carbon::parse($query->birthdate)->format('dd-MM-yyyy'))
                            ])
                        ];
                    }
                )->modalWidth('xl')->modalHeading('Edit User'),
                DeleteAction::make('delete')->action(
                    function($record){
                        $record->delete();
                        LogHistory::create([
                            'user_id' => auth()->user()->id,
                            'action' => "DELETE USER",
                        ]);

                        $this->notification()->success(
                            $title = 'Notification',
                            $description = auth()->user()->user_type.'_'.auth()->user()->name.' has delete a user record',
                        );


                        $message = auth()->user()->user_type.'_'.auth()->user()->name.' has delete a user record';

                        // broadcast(new ReceivedNotification());
                        ReceivedNotification::dispatch($message,auth()->user()->user_type);

                        sweetalert()->success('User deleted successfully');
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
