<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
public function index(Request $request)
    {
        $users = User::with('role')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('full_name', 'like', '%' . $name . '%')
                    ->orWhere('email', 'like', '%' . $name . '%');
            })
            ->paginate(5);
        return view('pages.user.index', compact('users'));
    }

    public function create()
    {
        return view('pages.user.create');
    }

public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $data = [
            'full_name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ];

        // Map role string to role_id
        $roleName = $request->input('role', $request->input('roles'));
        if ($roleName) {
            $role = \App\Models\Role::where('name', ucfirst(strtolower($roleName)))->first();
            $data['role_id'] = $role ? $role->id : \App\Models\Role::where('name', 'Customer')->value('id');
        } else {
            $data['role_id'] = \App\Models\Role::where('name', 'Customer')->value('id');
        }

        User::create($data);
        return redirect()->route('user.index');
    }
    
    public function show()
    {
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.user.edit', compact('user'));
    }

public function update(Request $request, $id)
    {
        $user = User::findOrfail($id);

        $data = [
            'full_name' => $request->input('name', $user->full_name),
            'email' => $request->input('email', $user->email),
        ];

        // Only update password if a new one is provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }

        // Map role string to role_id
        if ($request->has('role')) {
            $roleName = $request->input('role');
            $role = \App\Models\Role::where('name', ucfirst(strtolower($roleName)))->first();
            $data['role_id'] = $role ? $role->id : $user->role_id;
        }

        $user->update($data);
        return redirect()->route('user.index');
    }

    public function destroy($id){

        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index');
    }
}
