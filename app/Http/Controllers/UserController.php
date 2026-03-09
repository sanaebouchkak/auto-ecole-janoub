<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Candidat;
use App\Models\Formation;
use App\Models\Moniteur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
    {
        \Illuminate\Support\Facades\Gate::authorize('viewAny', User::class);

        $query = User::query();

        // Recherche textuelle
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filtre par rôle (Enum value)
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(Request $request)
    {
        \Illuminate\Support\Facades\Gate::authorize('create', User::class);
        $type = $request->query('type', 'candidat');
        return view('users.form', compact('type'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        \Illuminate\Support\Facades\Gate::authorize('create', User::class);

        $isStaff = $request->user_type === 'staff';

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8',
            'is_active' => 'boolean'
        ];

        if ($isStaff) {
            $rules['role'] = ['required', \Illuminate\Validation\Rule::enum(\App\Enums\UserRole::class)];
        }

        $validated = $request->validate($rules);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = $request->has('is_active') ? $request->is_active : true;

        if (!$isStaff) {
            $validated['role'] = \App\Enums\UserRole::CANDIDAT;
        }

        $user = User::create($validated);

        if ($user->isCandidat()) {
            Candidat::create(['user_id' => $user->id]);
        } elseif ($user->isMoniteur()) {
            Moniteur::create(['user_id' => $user->id]);
        }

        return redirect()->route(auth()->user()->role->value . '.users.index')->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        \Illuminate\Support\Facades\Gate::authorize('update', $user);
        $type = $user->isCandidat() ? 'candidat' : 'staff';
        return view('users.form', compact('user', 'type'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        \Illuminate\Support\Facades\Gate::authorize('update', $user);

        $isStaff = $request->user_type === 'staff' || !$user->isCandidat();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'required|string|max:20',
            'is_active' => 'boolean'
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'string|min:8';
        }

        if ($isStaff && auth()->user()->isAdmin()) {
            $rules['role'] = ['required', \Illuminate\Validation\Rule::enum(\App\Enums\UserRole::class)];
        }

        $validated = $request->validate($rules);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $validated['is_active'] = $request->has('is_active') ? $request->is_active : false;

        $user->update($validated);

        return redirect()->route(auth()->user()->role->value . '.users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        \Illuminate\Support\Facades\Gate::authorize('delete', $user);

        if ($user->id === auth()->id()) {
            return redirect()->route(auth()->user()->role->value . '.users.index')->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();
        return redirect()->route(auth()->user()->role->value . '.users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }

    /**
     * Exporter tous les utilisateurs en PDF.
     */
    public function exportPdf()
    {
        \Illuminate\Support\Facades\Gate::authorize('viewAny', User::class);
        
        $users = User::orderBy('role')->orderBy('name')->get();
        $pdf = Pdf::loadView('users.pdf', compact('users'))->setPaper('a4', 'landscape');
        
        return $pdf->download('utilisateurs_' . now()->format('Y-m-d') . '.pdf');
    }
}
