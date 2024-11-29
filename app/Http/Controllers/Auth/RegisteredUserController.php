<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'npk' => ['required', 'string', 'numeric', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'posisi' => ['required', 'string'],
            'department' => ['required', 'string', 'in:quality_unit,quality_body'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'npk' => $request->npk,
            'password' => Hash::make($request->password),
            'posisi' => $request->posisi,
            'department' => $request->department,
        ]);

        event(new Registered($user));

        Auth::login($user);

        if ($user->department === 'quality_unit') {
            return redirect(RouteServiceProvider::HOME); // Quality Unit redirect ke Home
        } else {
            return redirect()->route('dashboard.quality_body'); // Quality Body redirect ke dashboard khusus
        }
    }
}
