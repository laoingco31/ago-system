<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Search by name or email
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(10);
        $roles = User::select('role')->distinct()->pluck('role'); // Dito galing ang $roles

        return view('users.index', compact('users', 'roles'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        // Limitahan ang access: Only 'admin' or 'editor' can edit
        if (auth()->user()->role != 'admin' && auth()->user()->role != 'editor') {
            return redirect()->route('users.index')->with('error', 'You are not authorized to edit this user.');
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Limitahan ang access: Only 'admin' or 'editor' can update
        if (auth()->user()->role != 'admin' && auth()->user()->role != 'editor') {
            return redirect()->route('users.index')->with('error', 'You are not authorized to update this user.');
        }

        $user->update($request->all());

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Only admin can delete
        if (auth()->user()->role != 'admin') {
            return redirect()->route('users.index')->with('error', 'You are not authorized to delete this user.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
