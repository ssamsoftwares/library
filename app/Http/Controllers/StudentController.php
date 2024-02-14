<?php

namespace App\Http\Controllers;

use App\Imports\ImportStudent;
use App\Models\BulkUploadStudent;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;


class StudentController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:student-list|student-view|student-create|student-edit|student-delete', ['only' => ['index', 'view']]);
        $this->middleware('permission:student-view', ['only' => ['view']]);
        $this->middleware('permission:student-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:student-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:student-delete', ['only' => ['destroy']]);
    }

    // Show list Student


    public function index(Request $request)
    {

        $search = $request->search;
        $authuser = Auth::user();
        $students = Student::query()->with('createby','plan');

        // Check if the user is a superadmin
        if ($authuser->hasRole('superadmin')) {
            // Superadmin can see all students, so no need to filter
        } else {
            // For admin and manager, see students by the current user's id
            $students->where('user_id', $authuser->id);
        }

        if (!empty($request->search)) {

            $students->where(function ($subquery) use ($search) {
                $subquery->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', $search . '%')
                    ->orWhere('personal_number', 'like', $search . '%')
                    ->orWhere('dob', 'like', $search . '%');
                    $subquery->orWhereHas('plan', function ($query) use ($search) {
                        $query->where('library_branch', 'like', '%' . $search . '%');
                    });

                if (Auth::user()->hasRole('superadmin')) {
                    $subquery->orWhereHas('createby', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
                }
            });
        }

        $students = $students->orderBy('created_at', 'desc')->paginate(10);

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
            'password' => 'required|same:confirm-password',
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
            // $data['password'] = Hash::make($data['password']);
            $data['user_id'] = Auth::id();
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
            'password' => 'same:confirm-password',
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

            if (!empty($data['password'])) {
                $data['password'] = $data['password'];
            } else {
                $data = Arr::except($data, array('password'));
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

    // Student status change
    public function studentStatusUpdate($id)
    {
        $studentBlock = Student::find($id);
        $studentBlock->status = $studentBlock->status == 'active' ? 'block' : 'active';
        $studentBlock->update();
        return redirect()->back()->with('status',  $studentBlock->name . ' Student status has been updated.');
    }



    /**
     *---------------------------------------------------------------------
     * BULK UPLOAD STUDENTES FUNCTIONS
     *---------------------------------------------------------------------
     */

    public function bulkUploadStudents(Request $request)
    {
        $search = $request->search;
        $authuser = Auth::user();
        $bulkUploadStudents = BulkUploadStudent::with('createbyStudent');

         // If user is not a superadmin, filter BulkUploadStudent by created_by
         if (!$authuser->hasRole('superadmin')) {
            $bulkUploadStudents->where('created_by', $authuser->id);
        }

        if (!empty($request->search)) {

            $bulkUploadStudents->where(function ($subquery) use ($search) {
                $subquery->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone_number', 'like', '%' . $search . '%')
                    ->orWhere('course', 'like', '%' . $search . '%')
                    ->orWhere('graduation', 'like', '%' . $search . '%')
                    ->orWhereHas('createbyStudent', function ($query) use ($search) {
                        $query->where('users.name', 'like', '%' . $search . '%');
                    });
            });
        }

        $bulkUploadStudents = $bulkUploadStudents->paginate(10);

        return view('admin.bulkUpload_student.all', compact('bulkUploadStudents'));
    }


    public function bulkUploadStudentsView(BulkUploadStudent $bulkUploadStudent)
    {
        return view('admin.bulkUpload_student.view', compact('bulkUploadStudent'));
    }

    public function bulkUploadStudentsEdit(BulkUploadStudent $bulkUploadStudent)
    {
        return view('admin.bulkUpload_student.edit', compact('bulkUploadStudent'));
    }

    public function bulkUploadStudentsUpdate(Request $request, BulkUploadStudent $bulkUploadStudent)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $bulkUploadStudent->update($data);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('status', $e->getMessage());
        }
        DB::commit();
        return redirect()->back()->with('status', 'Student Updated Successfully !');
    }


    public function importFileView()
    {
        return view('admin.bulkUpload_student.bulk_upload');
    }

    public function import(Request $request)
    {
        DB::beginTransaction();
        try {
            $file = $request->file('file');
            $import = new ImportStudent();
            Excel::import($import, $file);
            $newStudentCount = $import->getNewStudentCount();
            $updatedStudentCount = $import->getUpdatedStudentCount();
            $totalStudentCount = $newStudentCount + $updatedStudentCount;
            $uploadedFileName = $file->getClientOriginalName();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'File import failed: ' . $e->getMessage()]);
        }
        DB::commit();
        $message = "File <strong>'{$uploadedFileName}'</strong> successfully imported. <strong>{$newStudentCount}</strong> new Students added and <strong>{$updatedStudentCount}</strong> updated from <strong>{$totalStudentCount}</strong> records.";
        return response()->json(['message' => $message]);
    }


    public function downloadSampleCsv()
    {
        DB::beginTransaction();
        $filePath = storage_path('app/public/sample.csv');
        $fileName = 'sample.csv';
        if (file_exists($filePath)) {
            return response()->download($filePath, $fileName, [
                'Content-Type' => 'application/csv',
                'Content-Disposition' => 'attachment; filename=' . $fileName,
            ]);
        }
        return redirect()->back()->with('status', 'Sample CSV file Not Found.');
    }
}
