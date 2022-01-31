<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmMail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Models\Permission_role;
use Validator;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function loginPage()
    {
        if (Auth::check()) {
            return redirect('/');
        } else {
            return view('login');
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Auth::attempt($credentials)) {
                return response()->json(['status' => 'success', 'message' => 'เข้าสู่ระบบสำเร็จ']);
            } else {
                return response()->json(['status' => 'fail', 'message' => 'เข้าสู่ระบบไม่สำเร็จ, อีเมลหรือรหัสผ่านไม่ถูกต้อง']);
            }
        } else {
            return response()->json(['status' => 'fail', 'message' => 'เข้าสู่ระบบไม่สำเร็จ, อีเมลหรือรหัสผ่านไม่ถูกต้อง']);
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user) {
            return response()->json(['status' => 'fail', 'message' => 'อีเมลนี้มีแล้วในระบบ ']);
        } else {
            if ($validator->fails()) {
                return response()->json(['status' => 'fail', 'message' => 'โปรดระบุข้อมูลให้ครบถ้วน']);
            }

            User::insert(array_merge(
                $validator->validated(),
                ['password' => bcrypt($request->password), 'name' => $request->email]
            ));

            return response()->json(['status' => 'success', 'message' => 'สมัครสมาชิกสำเร็จ']);
        }
    }
}
