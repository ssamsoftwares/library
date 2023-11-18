<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;



class StudentDashboardController extends Controller
{

    // Student Dashboard

    public function studentdashboard(Request $request)
    {
        if (!session()->has('student_name')) {
            return redirect()->route('student.login')->with('status', "Unauthorized access student");
        }

        $studentName = session('student_name');
        $checkStudent = Student::where('email', $studentName)->first();

        if (!$checkStudent) {
            return redirect()->route('student.login')->with('status', "Student not found");
        }

        $currentDate = date('Y-m-d');

        // Count of active plans
        $total['activePlansCount'] = Plan::where('student_id', $checkStudent->id)
            ->whereDate('valid_upto_date', '>=', $currentDate)
            ->count();

        // Count of expired plans
        $total['expiredPlansCount'] = Plan::where('student_id', $checkStudent->id)
            ->whereDate('valid_upto_date', '<', $currentDate)
            ->count();

        //  plans for the next 5 days
        $plans = Plan::with('student')
            ->where('student_id', $checkStudent->id)
            ->whereDate('valid_upto_date', '>=', Carbon::now())
            ->whereDate('valid_upto_date', '<=', Carbon::now()->addDays(5))
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('students.student_dashboard')->with(compact('plans', 'checkStudent', 'total'));
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


    // Plan details show student


    public function planDetails(Request $request)
    {
        $studentEmail = session('student_name');
        $student = Student::where('email', $studentEmail)->first();

        if (!$student) {
            return redirect()->route('student.login')->with('status', "Student not found");
        }

        $currentDate = Carbon::now();
        $plans = Plan::with('student')
            ->where('student_id', $student->id)
            ->orderBy('valid_upto_date', 'ASC')
            ->get();

        // active and expired plans
        $activePlans = $plans->filter(function ($plan) use ($currentDate) {
            return $currentDate->lte($plan->valid_upto_date);
        });

        $expiredPlans = $plans->filter(function ($plan) use ($currentDate) {
            return $currentDate->gt($plan->valid_upto_date);
        });

        return view('students.plan_details', compact('activePlans', 'expiredPlans', 'student'));
    }


}
