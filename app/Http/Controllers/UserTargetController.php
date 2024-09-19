<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserTargetRequest;
use App\Models\User;
use App\Models\UserTarget;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserTargetController extends Controller
{
    public function index(): Response
    {
        $data = [];

        $data['users'] = User::query()
            ->orderBy('name')
            ->get();
        $data['targetItems'] = [
            'calls_target',
            'prospect_target',
            'profit_target',
            'rejuve_target',
            'iho_target',
            'lubricant_target',
        ];
        $data['userTargets'] = UserTarget::all()->keyBy('user_id');

        return Inertia::render('Admin/UserTargetsPage', $data);
    }

    public function store(UserTargetRequest $request): RedirectResponse
    {

        $validated = $request->validated();

        foreach ($validated['targets'] as $userId => $targetData) {
            UserTarget::updateOrCreate(
                ['user_id' => $userId],
                $targetData
            );
        }

        return redirect()->route('user-targets.index');
    }
}
