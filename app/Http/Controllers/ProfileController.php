<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('admin.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'nullable|string',
            'birth_date' => 'required|date',
            'country' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'profile_image' => 'nullable|image|max:2048',
            'residential_proofs.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'education' => 'nullable|string',
            'occupation' => 'nullable|string',
        ]);

        // Assign explicitly to avoid fillable issues
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->birth_date = $request->input('birth_date');
        $user->age = $request->input('birth_date') ? Carbon::parse($request->input('birth_date'))->age : null;
        $user->country = $request->input('country');
        $user->state = $request->input('state');
        $user->city = $request->input('city');
        $user->education = $request->input('education');
        $user->occupation = $request->input('occupation');

        // Profile image handling
        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $user->profile_image = $request->file('profile_image')->store('profiles', 'public');
        }

        // Residential proofs (append to existing array)
        $proofs = $user->residential_proofs ?? [];
        if ($request->hasFile('residential_proofs')) {
            foreach ($request->file('residential_proofs') as $file) {
                $proofs[] = $file->store('residential_proofs', 'public');
            }
            $user->residential_proofs = $proofs;
        }

        // mark profile completed
        $user->profile_completed = 1;

        $user->save();

        // refresh user from DB (optional)
        $user->refresh();

        return redirect()->route('admin.dashboard')->with('success', 'Profile updated.');
    }
}
