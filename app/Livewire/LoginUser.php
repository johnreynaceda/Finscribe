<?php

namespace App\Livewire;

use App\Models\TimeRecord;
use App\Models\User;
use App\Notifications\Otp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Illuminate\Validation\ValidationException;
use WireUi\Traits\Actions;

class LoginUser extends Component
{
    public $email, $password;
    public $one, $two, $three, $four, $date;
    public $modal = false;
    public $user_id;
    public $option_modal = false;
    public $option;
    use Actions;


    public function inputUpdated($currentInput, $nextInput)
    {
        if ($this->$currentInput) {
            $this->dispatchBrowserEvent('autofocusInput', ['inputName' => $nextInput]);
        }
    }

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function attemptLogin(){
        sleep(1);

        $this->validate();
        $credentials = [
        'email' => $this->email,
        'password' => $this->password,
    ];

    if (Auth::attempt($credentials)) {

        $this->option_modal = true;


    } else {

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }



}

public function optionMethod($option){
    $this->option = $option;

    if ($this->option == 'email') {
       $data = User::where('email', $this->email)->first();
        $this->user_id = $data->id;
        $random = rand(1000, 9999);
        $data->update([
            'otp' => $random,
        ]);

        $data->notify(new Otp($data->name, $data->otp));
        $this->option_modal = false;

        $this->modal = true;

    }else{
        dd('no sms found');
    }

}

public function verifyAccount(){
    $this->validate([
        'one' => 'required|numeric|digits:1',
        'two' => 'required|numeric|digits:1',
        'three' => 'required|numeric|digits:1',
        'four' => 'required|numeric|digits:1',
    ]);
    $otp = $this->one . $this->two . $this->three . $this->four;
    $verify = User::where('id', $this->user_id)->where('otp', $otp)->first();
    if ($verify) {
        $user = User::where('id', $this->user_id)->first();

        $user->update([
            'isLoggedIn' => true,
        ]);

        auth()->loginUsingId($user->id);

        TimeRecord::create([
            'user_id' => $user->id,
            'start_time' => Carbon::parse(now()),
        ]);

        $this->modal = false;
        sleep(5);
        return redirect()->route('dashboard');
    } else {
        $this->reset(['one', 'two', 'three', 'four']);
        $this->dialog()->error(
            $title = 'Invalid OTP',
            $description = 'Please enter the correct OTP sent to your email address',
        );
    }
}

    public function render()
    {
        return view('livewire.login-user');
    }
}
