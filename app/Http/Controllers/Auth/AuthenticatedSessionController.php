<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\TimeRecord;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        auth()->user()->update([
            'isLoggedIn' => false,
        ]);
        $data = TimeRecord::where('end_time', null)->orderBy('created_at', 'DESC')->first();
        if($data){
            $data->update([
                'end_time' => Carbon::parse(now()),
                'duration' => Carbon::parse(now())->diffForHumans(Carbon::parse($data->start_time)),
            ]);
        }
        Auth::guard('web')->logout();



        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
