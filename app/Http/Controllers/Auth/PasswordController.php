<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;

class PasswordController extends Controller
{
    public function edit()
    {
        return view('admin.profile.password');
    }

    public function update(Request $request)
{
    $rules = [
        'password' => ['required', 'confirmed', Rules\Password::min(10)->letters()->numbers()],
    ];

    if (! $request->user()->must_change_password) {
        $rules['current_password'] = ['required', 'current_password'];
    }

    $validated = $request->validate($rules);

    $request->user()->forceFill([
        'password' => $validated['password'],
        'must_change_password' => false,
    ])->save();

    return redirect()->route('admin.dashboard')->with('status', __('Contraseña actualizada correctamente.'));
}
}