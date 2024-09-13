<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function index(Request $request): Response
    {
        $data = [
            'users' => User::query()
                ->with('manager')
                ->orderBy('name')
                ->get(),
        ];

        return Inertia::render('Admin/UsersPage', $data);
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

        return Inertia::render('Admin/Users/Components/EditUser', $data);
    }

    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        $user->update($request->validated());

        return redirect()->route('users.index');
    }

}
