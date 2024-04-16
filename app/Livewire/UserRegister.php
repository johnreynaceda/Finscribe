<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\UserInformation;
use Livewire\Component;

class UserRegister extends Component
{
    public $firstname, $lastname, $email, $contact, $birthdate, $password, $confirm_password, $is_checked;


    public function render()
    {
        return view('livewire.user-register');
    }

    public function register(){
        sleep(2);
        $this->validate([
            'firstname' => 'required',
            'lastname' =>'required',
            'email' =>'required|email|unique:users,email',
            'contact' =>'required',
            'birthdate' =>'required',
            'password' => 'required',
            'confirm_password' => 'same:password'
        ]);

        $user = User::create([
            'name' => $this->firstname. ' ' . $this->lastname,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'user_type' => 'Employee'
        ]);

        UserInformation::create([
            'user_id' => $user->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'contact' => $this->contact,
            'birthdate' => $this->birthdate,
        ]);

        auth()->loginUsingId($user->id);

        sleep(2);

        return redirect()->route('dashboard');
    }
}
