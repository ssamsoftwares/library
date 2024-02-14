<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class StudentAuthController extends Controller
{
    // Student Login Function
    public function studentLoginView()
    {
        return view('auth.student.login');
    }

    // Student Login

    public function studentLogin(Request $request)
    {
        $this->validate($request, [
            'login' => 'required',
            'password' => 'required',
        ]);

        $login = $request->input('login');
        $password = $request->input('password');

        $student = Student::where(function ($query) use ($login) {
            $query->where('email', $login)->orWhere('aadhar_number', $login);
        })->first();

        if ($student && $password == $student->password) {
            $request->session()->put('student_name', $student->email);
            return redirect()->route('student.profile')->with('status', 'Student has successfully logged in...');
        } else {
            return redirect()->route('student.login')->with('status', 'Oops! Invalid login credentials');
        }
    }


    // Student Logout
    public function studentLogout()
    {
        Auth::guard('student')->logout();
        session()->forget('student_name');
        return redirect()->route('student.login');
    }


    // FORGET PASSWORD

    public function forgotPassword()
    {
        return view('auth.student.forgot-password');
    }


    public function forgotPasswordStore(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:students',
        ]);

        $student = Student::where('email', $request->email)->first();

        if (!$student) {
            return back()->withErrors(['email' => 'Invalid email address.'])->withInput();
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );

        Mail::send('auth.student.verify-email', [
            'token' => $token,
            'email' => $student->email,
            'name' => $student->name,
        ], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return back()->with('status', 'We have e-mailed your password reset link!');
    }


    public function resetPassword($token)
    {

        return view('auth.student.reset-password', ['token' => $token]);
    }


    public function resetPasswordStore(Request $request)
    {
        $request->validate([
            'email' => 'email|exists:students',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_reset_tokens')
            ->where([
                'email' => $request->email,
                'token' => $request->token,
            ])
            ->where('created_at', '>', Carbon::now()->subHours(24))
            ->first();

        if (!$updatePassword) {
            return back()->with('status', 'Invalid or expired token!');
        }

        $user = Student::where('email', $request->email)
            ->update(['password' => $request->password]);

        DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();

        return redirect()->route('student.login')->with('status', 'Your password has been changed!');
    }



}
