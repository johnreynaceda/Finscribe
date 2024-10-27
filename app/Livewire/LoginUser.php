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
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use WireUi\Traits\Actions;

class LoginUser extends Component
{
    public $email, $password;
    public $one, $two, $three, $four, $date;
    public $modal = false;
    public $user_id;
    public $option_modal = false;
    public $contact_number;
    public $option;
    use Actions;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function inputUpdated($currentInput, $nextInput)
    {
        if ($this->$currentInput) {
            $this->dispatchBrowserEvent('autofocusInput', ['inputName' => $nextInput]);
        }
    }

    public function attemptLogin()
    {
        sleep(1);
        $this->validate();

        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        $this->ensureIsNotRateLimited();

        if (Auth::attempt($credentials)) {
            $this->option_modal = true;
            RateLimiter::clear($this->throttleKey());
        } else {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
{
    if (!RateLimiter::tooManyAttempts($this->throttleKey(), 3)) {
        return;
    }

    // Use request() here instead of $this
    event(new Lockout(request()));

    $seconds = RateLimiter::availableIn($this->throttleKey());

    throw ValidationException::withMessages([
        'email' => trans('auth.throttle', [
            'seconds' => $seconds,
            'minutes' => ceil($seconds / 60),
        ]),
    ]);
}

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::lower($this->email) . '|' . request()->ip();
    }

    public function optionMethod($option)
    {
        $this->option = $option;

        $user = User::where('email', $this->email)->first();
        if (!$user) {
            throw ValidationException::withMessages(['email' => 'User not found.']);
        }

        $this->user_id = $user->id;
        $otp = rand(1000, 9999);

        $user->update(['otp' => $otp]);

        if ($option === 'email') {
            $user->notify(new Otp($user->name, $otp));
        } else {
            $this->contact_number = $user->userInformation->contact;
            $this->sendOtpToPhone($user->userInformation->contact, $user->name, $otp);
        }

        $this->option_modal = false;
        $this->modal = true;
    }

    private function sendOtpToPhone($contact, $name, $otp)
    {
        $ch = curl_init();
        $parameters = [
            'apikey' => '1aaad08e0678a1c60ce55ad2000be5bd', // Your API KEY
            'number' => $contact,
            'message' => "Dear {$name},\nWe have an OTP code that you can use to verify your account.\nOTP CODE : {$otp}",
            'sendername' => 'FINSCRIBE'
        ];

        curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }

    public function verifyAccount()
    {
        $this->validate([
            'one' => 'required|numeric|digits:1',
            'two' => 'required|numeric|digits:1',
            'three' => 'required|numeric|digits:1',
            'four' => 'required|numeric|digits:1',
        ]);

        $otp = $this->one . $this->two . $this->three . $this->four;
        $user = User::where('id', $this->user_id)->where('otp', $otp)->first();

        if ($user) {
            $user->update(['isLoggedIn' => true]);
            Auth::loginUsingId($user->id);

            TimeRecord::create([
                'user_id' => $user->id,
                'start_time' => now(),
            ]);

            $this->modal = false;
            sleep(1);
            return redirect()->route('dashboard');
        } else {
            $this->reset(['one', 'two', 'three', 'four']);
            $this->dialog()->error(
                title: 'Invalid OTP',
                description: 'Please enter the correct OTP sent to your email address'
            );
        }
    }

    public function render()
    {
        return view('livewire.login-user');
    }
}
