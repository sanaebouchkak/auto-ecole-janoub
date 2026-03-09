<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);
        
        $userCount = User::count();
        $role = $userCount === 0 ? \App\Enums\UserRole::ADMIN : \App\Enums\UserRole::CANDIDAT;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $role,
            'is_active' => true,
        ]);

        if ($role === \App\Enums\UserRole::CANDIDAT) {
            \App\Models\Candidat::create(['user_id' => $user->id]);
        }

        event(new Registered($user));

        Auth::login($user);

        $redirectTo = match ($user->role) {
            \App\Enums\UserRole::ADMIN      => 'admin.dashboard',
            \App\Enums\UserRole::ASSISTANTE => 'assistante.dashboard',
            \App\Enums\UserRole::MONITEUR   => 'moniteur.dashboard',
            \App\Enums\UserRole::CANDIDAT   => 'candidat.dashboard',
            default                         => 'dashboard',
        };

        return redirect()->route($redirectTo);
    }
}
