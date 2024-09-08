<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function index()
    {
        $data = [
            'users' => User::query()
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
        ];

        return Inertia::render('Users/UserPage', $data);
    }

}
