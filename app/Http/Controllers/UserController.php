<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

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

}
