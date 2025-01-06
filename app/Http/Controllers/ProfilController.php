<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;


class ProfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('profil/index');
    }

    public function update(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::user()->id,
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|max:12|required_with:current_password',
            'password_confirmation' => 'nullable|min:8|max:12|required_with:new_password|same:new_password',

        ]);
        $user = User::findOrFail(Auth::user()->id);
        $user->email = $request->input('email');

        if (!is_null($request->input('current_password'))) {
            if (Hash::check($request->input('current_password'), $user->password)) {
                $user->password = Hash::make($request->input('new_password'));
            } else {
                return redirect()->back()->withInput();
            }
        }

        $user->save();
        Alert::success('Berhasil!', 'Profile berhasil terupdate');
        return redirect()->route('profil');
    }
}
