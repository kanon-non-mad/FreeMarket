<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('profile.index',compact('user'));
    }

    public function edit() {
    
        return view('profile.edit',compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        $user = auth()->user();

        $data = $request->validated();

        $user->update([
            'name' => $data['name'],
            'postal_code' => $data['postal_code'],
            'address' => $data['address'],
            'building' => $data['building'],
        ]);

        return redirect()->route('profile.index');
    }
}
