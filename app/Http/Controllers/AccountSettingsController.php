<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AccountSettingsController extends Controller
{
    public function edit(Request $request): View
    {
        return view('account.settings', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'notifications_enabled' => ['required', 'boolean'],
            'language' => ['required', 'string', 'max:10'],
        ]);

        $user = $request->user();
        $user->notifications_enabled = $data['notifications_enabled'];
        $user->language = $data['language'];
        $user->save();

        return Redirect::route('account.settings')->with('status', 'settings-updated');
    }
}
