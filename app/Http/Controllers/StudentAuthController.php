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
use Illuminate\Validation\Rule;

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
        ]);

        $login = $request->input('login');
        $student = Student::where(function ($query) use ($login) {
            $query->where('email', $login)->orWhere('aadhar_number', $login);
        })->first();

        if ($student) {
            $request->session()->put('student_name', $student->email);
            return redirect()->route('student.dashboard')->with('status', 'Student has successfully logged in...');
        } else {
            return redirect()->route('student.login')->with('error', 'Oops! Student not found with this email or aadhar number');
        }
    }




    // Student Logout
    public function studentLogout()
    {
        Auth::guard('student')->logout();
        session()->forget('student_name');
        return redirect()->route('student.login');
    }


    // Student Dashboard
    public function studentdashboard(Request $request)
    {
        if (!session()->has('student_name')) {
            return redirect()->route('student.login')->with('status', "Unauthorized access student");
        }
        $studentName = session('student_name');
        $checkStudent = Student::where('email', $studentName)->first();
        $currentDate = date('Y-m-d');
        $plans = Plan::with('student')
            ->where('student_id', $checkStudent->id)
            ->whereDate('plans.valid_upto_date', '>=', Carbon::now())
            ->whereDate('plans.valid_upto_date', '<=', Carbon::now()->addDays(5));

        $plans = $plans->orderBy('created_at', 'DESC')->paginate(10);
        return view('students.student_dashboard')->with(compact('plans', 'checkStudent'));
    }

    // Student Profile Show

    public function studentProfile()
    {
        if (!session()->has('student_name')) {
            return redirect()->route('student.login')->with('status', "Unauthorized access student");
        }
        $studentName = session('student_name');
        $studentProfile = Student::where('email', $studentName)->first();
        return view('students.stu_profile', compact('studentProfile'));
    }

    // Student Profile edit
    public function studentProfileEdit()
    {
        if (!session()->has('student_name')) {
            return redirect()->route('student.login')->with('status', "Unauthorized access student");
        }
        $studentName = session('student_name');
        $student = Student::where('email', $studentName)->first();
        return view('students.stu_edit_profile', compact('student', 'studentName'));
    }

    // Student Profile Update

    public function studentProfileUpdate(Request $request, Student $student)
    {
        $studentName = session('student_name');
        $student = Student::where('email', $studentName)->first();
        if (!$student) {
            return redirect()->back()->with('status', 'Student not found');
        }
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', Rule::unique('students', 'email')->ignore($student->id)],
            'personal_number' => ['required', Rule::unique('students', 'personal_number')->ignore($student->id)],
            'aadhar_number' =>  ['required', Rule::unique('students', 'aadhar_number')->ignore($student->id)],
            'aadhar_front_img' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'aadhar_back_img' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'image' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        DB::beginTransaction();

        try {
            $data = $request->all();

            // AADHAR FRONT IMG
            if ($request->hasFile('aadhar_front_img')) {
                // Delete the old image if it exists
                if (is_file(public_path($student->aadhar_front_img))) {
                    unlink(public_path($student->aadhar_front_img));
                }

                $aadharFrontImg = $request->file('aadhar_front_img');
                $filename = uniqid() . '.' . $aadharFrontImg->getClientOriginalExtension();
                $aadharFrontImg->move(public_path('student_aadhar_img'), $filename);
                $data['aadhar_front_img'] = 'student_aadhar_img/' . $filename;
            }

            // AADHAR BACK IMG
            if ($request->hasFile('aadhar_back_img')) {
                // Delete the old image if it exists
                if (is_file(public_path($student->aadhar_back_img))) {
                    unlink(public_path($student->aadhar_back_img));
                }

                $aadharBackImg = $request->file('aadhar_back_img');
                $filename = uniqid() . '.' . $aadharBackImg->getClientOriginalExtension();
                $aadharBackImg->move(public_path('student_aadhar_img'), $filename);
                $data['aadhar_back_img'] = 'student_aadhar_img/' . $filename;
            }

            // STUDENT PHOTO
            if ($request->hasFile('image')) {
                // Delete the old image if it exists
                if (is_file(public_path($student->image))) {
                    unlink(public_path($student->image));
                }

                $studentImg = $request->file('image');
                $filename = uniqid() . '.' . $studentImg->getClientOriginalExtension();
                $studentImg->move(public_path('student_img'), $filename);
                $data['image'] = 'student_img/' . $filename;
            }

            $student->update($data);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('status', $e->getMessage());
        }

        DB::commit();
        return redirect()->back()->with('status', 'Student updated successfully!');
    }
}
