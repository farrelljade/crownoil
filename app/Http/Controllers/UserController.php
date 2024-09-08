<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function index()
    {
        $data = [
            'users' => User::query()
                ->with('manager')
                ->orderBy('name')
                ->get(),
        ];

        return Inertia::render('Users/UsersPage', $data);
    }

    public function show(User $user): Response
    {
        $user = User::with('manager')->find($user->id);

        $data = [
            'user' => $user,
            'managers' => User::query()
                ->where('id', '!=', $user->id)
                ->orderBy('name', 'asc')
                ->get(),
        ];

        return Inertia::render('Users/UserPage', $data);
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'manager_id' => 'nullable|exists:users,id',
        ]);

        $user->update($validatedData);

        return redirect()->route('users.show', $user);
    }

}
