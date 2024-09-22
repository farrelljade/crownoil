<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserTargetRequest;
use App\Models\User;
use App\Models\UserTarget;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class UserTargetController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/UserTargetsPage', $data);
    }

    public function store(UserTargetRequest $request): RedirectResponse
    {

        $validated = $request->validated();

        return redirect()->route('user-targets.index');
    }
}
