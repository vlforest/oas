<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckSetup
{
    public function handle(Request $request, Closure $next)
    {
        // Kiểm tra xem bảng users có dữ liệu hay không
        $setupCompleted = DB::table('users')->exists();

        if ($setupCompleted && ($request->is('setup') || $request->is('setup/*'))) {
            return redirect()->route('dashboard')->with('error', 'Ứng dụng đã được khởi tạo.');
        }

        if (!$setupCompleted && !$request->is('setup') && !$request->is('setup/*')) {
            return redirect()->route('setup.index')->with('error', 'Ứng dụng chưa được khởi tạo.');
        }

        return $next($request);
    }
}

