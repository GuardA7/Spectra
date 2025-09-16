<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Inertia\Inertia;

class ResetPasswordController extends Controller
{
    // Tampilkan halaman reset password
    public function show(Request $request)
    {
        return Inertia::render('Auth/ResetPassword', [
            'token' => $request->token,
            'email' => $request->email,
            'status' => session('status') ?? null,
        ]);
    }

    // Proses submit reset password
    public function submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $email = $request->email;
        $token = $request->token;

        // Ambil record password reset
        $record = DB::table('password_resets')->where('email', $email)->first();

        if (!$record) {
            return response()->json(['error' => 'Email tidak ditemukan atau token sudah kadaluwarsa.'], 422);
        }

        // Cek token menggunakan Hash::check (karena token di DB sudah di-hash)
        if (!Hash::check($token, $record->token)) {
            return response()->json(['error' => 'Token reset password tidak valid.'], 422);
        }

        // Cari user
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['error' => 'User tidak ditemukan.'], 422);
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        // Hapus token setelah berhasil reset
        DB::table('password_resets')->where('email', $email)->delete();

        return response()->json(['success' => 'Password berhasil direset!','redirect' => route('auth/login')], 200);
    }
}
