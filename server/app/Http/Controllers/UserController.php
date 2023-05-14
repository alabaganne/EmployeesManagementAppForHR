<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function update(Request $request) {
        $user = auth()->user();

        $validated = $request->validate([
            'id' => 'required|integer',
            'name' => 'required',
            'username' => 'alphanum|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);     
        $request->validate(['password_confirmation' => 'nullable|min:8']);

        if($user->id !== $validated['id']) {
            return response()->json([], 401);
        }

        if($validated['password'] === null) {
            $validated['password'] = $user->password;
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);
        return response()->json(new UserResource($user), 200);
    }

    public function setProfileImage(Request $request, User $user) {
        if($request->hasFile('profile_image')) {
            if($user->image_path !== 'storage/images/default-avatar.png') {
                Storage::delete('public/' . strstr($user->image_path, '/')); // Storage class methods default path = "/storage"
            }


            $extension = $request->profile_image->extension();
            $name = Str::random(8) . '.' . $extension;

            $request->profile_image->storeAs('public/images', $name);
            $user->image_path = 'storage/images/' . $name;

            $user->save();
        }

        return response()->json($user->image_path, 200);
    }
}