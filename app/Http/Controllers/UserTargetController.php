<?php

namespace App\Http\Controllers;

use App\Models\UserTarget;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserTargetController extends Controller
{
    public function index(): Response
    {
        $data = [];

        $data['userTargets'] = UserTarget::query()
            ->with('user')
            ->get();

        return Inertia::render('Admin/UserTargetsPage', $data);
    }
}
