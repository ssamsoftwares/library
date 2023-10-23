<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    // Show list Student
    public function index(Request $request)
    {
        $students = Student::query();
        if ($request->has('search')) {
            $search = $request->input('search');
            $students->where(function ($subquery) use ($search) {
                $subquery->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', $search . '%')
                    ->orWhere('personal_number', 'like', $search . '%')
                    ->orWhere('dob', 'like', $search . '%');
            });
        }
        $students = $students->paginate(10);

        return view('admin.student.all')->with(compact('students'));
    }


    // Add Student From
    public function create()
    {
        return view('admin.student.add');
    }

    // Store Student

    public function store(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'string|email|max:255|unique:students',
            'personal_number' => 'required|unique:students',
            'aadhar_number' => 'required|unique:students',
        ]);

        DB::beginTransaction();
        try {

            $data = $request->all();

            // AADHAR FRONT IMG
            if ($request->hasFile('aadhar_front_img')) {
                $aadharFrontImg = $request->file('aadhar_front_img');
                $filename = uniqid() . '.' . $aadharFrontImg->getClientOriginalExtension();
                $aadharFrontImg->move(public_path('student_aadhar_img'), $filename);
                $data['aadhar_front_img'] = 'student_aadhar_img/' . $filename;
            }

            // AADHAR BACK IMG
            if ($request->hasFile('aadhar_back_img')) {
                $aadharBackImg = $request->file('aadhar_back_img');
                $filename = uniqid() . '.' . $aadharBackImg->getClientOriginalExtension();
                $aadharBackImg->move(public_path('student_aadhar_img'), $filename);
                $data['aadhar_back_img'] = 'student_aadhar_img/' . $filename;
            }

            // STUDENT PHOTO
            if ($request->hasFile('image')) {
                $studentImg = $request->file('image');
                $filename = uniqid() . '.' . $studentImg->getClientOriginalExtension();
                $studentImg->move(public_path('student_img'), $filename);
                $data['image'] = 'student_img/' . $filename;
            }

            Student::create($data);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('status', $e->getMessage());
        }
        DB::commit();
        return redirect()->back()->with('status', 'Student Added successfuly !');
    }

    // view Student Form
    public function view(Student $student)
    {
        return view('admin.student.view')->with(compact('student'));
    }

    // Edit Student Form
    public function edit(Student $student)
    {
        return view('admin.student.edit')->with(compact('student'));;
    }

    // Update Student


    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', Rule::unique('students', 'email')->ignore($student->id)],
            'personal_number' => ['required', Rule::unique('students', 'personal_number')->ignore($student->id)],
            'aadhar_number' =>  ['required', Rule::unique('students', 'aadhar_number')->ignore($student->id)],
            // 'emergency_number' => ['required'],
            // 'dob' => ['required'],
            // 'course' => ['required'],
            // 'current_address' => ['required'],
            // 'permanent_address' => ['required'],
            // 'valid_from_date' => ['required'],
            // 'valid_upto_date' => ['required'],
            // 'mode_of_payment' => ['required'],
            // 'subscription' => ['required'],
            // 'remark_singnature' => ['required'],
            // 'hall_number' => ['required'],
            // 'vehicle_number' => ['required'],
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

    // Delete Student
    public function destroy(Student $student)
    {
        DB::beginTransaction();
        try {
            $student->delete();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('status', 'Student cannot be deleted!');
        }
        DB::commit();
        return redirect()->back()->with('status', 'Student deleted successfully!');
    }
}