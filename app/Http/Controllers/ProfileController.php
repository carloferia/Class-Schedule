<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        $user        = Auth::user();
        $expenseCount = Expense::where('user_id', $user->id)->count();
        $totalSpent   = Expense::where('user_id', $user->id)->sum('amount');

        return view('profile.show', compact('user', 'expenseCount', 'totalSpent'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'email'           => ['required', 'email', 'unique:users,email,' . $user->id],
            'gender'          => ['nullable', 'in:Male,Female,Other'],
            'password'        => ['nullable', 'confirmed', Password::min(8)],
            'profile_picture' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
        ]);

        $data = [
            'name'    => $request->name,
            'email'   => $request->email,
            'gender'  => $request->gender,
        ];

        // Handle password update
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $directory = public_path('uploads/profile-pictures');

            if (! File::isDirectory($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            if ($user->profile_picture && str_starts_with($user->profile_picture, 'uploads/') && File::exists(public_path($user->profile_picture))) {
                File::delete(public_path($user->profile_picture));
            }

            $filename = uniqid('profile_', true) . '.' . $file->getClientOriginalExtension();
            $file->move($directory, $filename);

            $data['profile_picture'] = 'uploads/profile-pictures/' . $filename;
        }

        $user->update($data);

        return redirect()->route('profile.show')
            ->with('success', 'Profile updated successfully!');
    }
}
