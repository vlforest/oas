<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        // Lấy danh sách tất cả người dùng, trừ người dùng đang đăng nhập
        $users = User::where('id', '!=', Auth::id())->get();
        return inertia('Admin/Users', [
            'users' => $users,
            'flash' => session()->get('flash', []),
        ]);
    }

    public function update(Request $request, User $user)
    {
        // Cập nhật role giữa 'Pending' và 'Verified'
        if (in_array($request->role, ['Pending', 'Verified'])) {
            $user->role = $request->role;
            $user->save();
            return redirect()->route('users.index')->with('flash', ['success' => 'User role updated successfully.']);
        }

        return redirect()->route('users.index')->with('flash', ['error' => 'Invalid role.']);
    }

    public function destroy(User $user)
    {
        // Xóa người dùng
        $user->delete();
        return redirect()->route('users.index')->with('flash', ['success' => 'User deleted successfully.']);
    }
}
