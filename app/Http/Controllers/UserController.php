<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Traits\LogActivity;

class UserController extends Controller
{
    use LogActivity;

    public function index()
    {
        $users = User::all();
        return view('user', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                "regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};':\"\\|,.<>\/?]).{8,}$/"
            ],
            'type' => 'required',
        ]);

        $data = $request->only(['name', 'username', 'email', 'type']);
        $data['password'] = Hash::make($request->password);

        $user = User::create($data);

        $this->addToLog('Membuat user baru: ' . $user->name);

        return redirect()->route('user')->with('success', 'User berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $users = User::all();
        return view('user', compact('user', 'users'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'type' => 'required|in:Admin,Operator',
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->type = $request->type;

        if ($request->filled('password')) {
            $request->validate([
                'password' => [
                    'string',
                    'min:8',
                    'confirmed',
                    "regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};':\"\\|,.<>\/?]).{8,}$/"
                ]
            ]);
            $user->password = Hash::make($request->password);
        }

        $user->save();

        $this->addToLog('Memperbarui user: ' . $user->name);

        return redirect()->route('user')->with('success', 'User berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $name = $user->name;
        $user->delete();

        $this->addToLog('Menghapus user: ' . $name);

        return redirect()->route('user')->with('success', 'User berhasil dihapus!');
    }
}
