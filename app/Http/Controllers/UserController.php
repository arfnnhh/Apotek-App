<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function signupsave(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'role' => 'required'
        ], [
            'name.min' => 'Nama user tidak boleh kurang dari 3 karakter',
            'name.required' => 'User harus memiliki nama',
            'email.required' => 'User harus memiliki email',
            'role.required' => 'User harus memiliki role'
        ]);

        $namePart = substr($request->input('name'), 0, 3);
        $emailPart = substr($request->input('email'), 0, 3);
        $combinedPassword = $namePart . $emailPart;

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($combinedPassword),
            'role' => $request->input('role')
        ]);

        return redirect()->route('apotek.userInfo')->with('userAdd', 'Berhasil menambah pengguna');
    }


    public function edit($id) {
        $user = User::find($id);
        return view('apotek.edit')->with('user', $user);
    }

    public function update($id, Request $request) {
        $user = User::find($id);

        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'role' => 'required',
        ], [
            'name.min' => 'Nama user tidak boleh kurang dari 3 karakter',
            'name.required' => 'User harus memiliki nama',
            'email.required' => 'User harus memiliki email',
            'role.required' => 'User harus memiliki role'
        ]);

        if (empty($request->input('password'))) {
            $user->update($request->except(['_token', 'submit', 'password']));
        } else {
            $user->update($request->except(['_token', 'submit']));
        }

        return redirect()->route('apotek.userInfo')->with('userUpdate', 'Berhasil memperbarui pengguna');
    }

    public function create(array $data) {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function destroy($id) {
        $user = User::find($id);
        $user->delete();

        return redirect()->route('apotek.userInfo')->with('userDelete', 'Berhasil menghapus pengguna');
    }

    public function userData() {
        $userData = User::all();
        return view('apotek.user', compact('userData'));
    }
}
