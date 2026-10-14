<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Show the application registration form.
     */
    public function showRegister(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request and assign a default role.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)],
        ]);

        // Assign a default role: Student (or create if not yet seeded)
        $defaultRole = Role::where('role_name', 'Student')->first() ?? Role::firstOrCreate(
            ['role_name' => 'Student'],
            ['description' => 'Default student account privileges.']
        );

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $defaultRole?->id,
        ]);

        Auth::login($user);

        return redirect()->route('students.index')->with('success', 'Registration successful! Welcome to the system.');
    }

    /**
     * Show the application login form.
     */
    public function showLogin(): View
    {
        $this->ensureDefaultAdminExists();

        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function login(Request $request): RedirectResponse
    {
        $this->ensureDefaultAdminExists();

        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('students.index'))->with('success', 'Logged in successfully.');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Ensure the default administrator account exists automatically upon running the app.
     */
    private function ensureDefaultAdminExists(): void
    {
        try {
            $adminRole = Role::firstOrCreate(
                ['role_name' => 'Administrator'],
                ['description' => 'System Administrator with full system control and privileges.']
            );

            User::updateOrCreate(
                ['email' => 'admin@example.com'],
                [
                    'name' => 'System Administrator',
                    'password' => Hash::make('password123'),
                    'role_id' => $adminRole->id,
                    'email_verified_at' => now(),
                ]
            );
        } catch (\Throwable) {
            // Fail gracefully if database is not yet ready
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
}
