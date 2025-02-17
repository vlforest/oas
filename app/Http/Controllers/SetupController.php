<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class SetupController extends Controller
{
    public function index()
    {
        // Kiểm tra xem bảng users có dữ liệu hay không
        $setupCompleted = DB::table('users')->exists();

        if ($setupCompleted) {
            return redirect()->route('dashboard')->with('error', 'Ứng dụng đã được khởi tạo.');
        }

        return Inertia::render('Setup/Index'); // Hiển thị trang khởi tạo
    }

    public function store(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'admin_email' => 'required|email|max:255',
            'admin_password' => 'required|string|confirmed',
        ]);

        // Tạo tài khoản admin
        $admin = new \App\Models\User();
        $admin->name = 'Administrator';
        $admin->email = $validated['admin_email'];
        $admin->password = Hash::make($validated['admin_password']);
        $admin->role = 'Administrator';
        $admin->save();

        return redirect()->route('dashboard')->with('success', 'Tài khoản quản trị được tạo thành công');
    }
}


