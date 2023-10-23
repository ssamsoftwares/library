<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class PlanController extends Controller
{
    //Show Plan List

    public function index(Request $request)
    {
        $plans = Plan::with('student');
        if ($request->has('search')) {
            $search = $request->input('search');
            $plans->where(function ($query) use ($search) {
                $query->where('plan', 'like', '%' . $search . '%')
                    ->orWhere('mode_of_payment', 'like', '%' . $search . '%')
                    ->orWhere('valid_from_date', 'like', '%' . $search . '%')
                    ->orWhere('valid_upto_date', 'like', '%' . $search . '%')
                    ->orWhereHas('student', function ($studentSubquery) use ($search) {
                        $studentSubquery->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%')
                            ->orWhere('aadhar_number', 'like', '%' . $search . '%');
                    });
            });
        }

        $plans = $plans->paginate(10);

        return view('admin.plan.all', compact('plans'));
    }



    //Asign Plan From
    public function create(Request $request)
    {
        session()->forget('status');
        $student = null;
        $fieldDisable = "true";

        if (!empty($request->student_search)) {
            $student = Student::where('personal_number', $request->input('student_search'))->orWhere('aadhar_number', $request->input('student_search'))->orWhere('email', $request->input('student_search'))->first();
            $fieldDisable = "false";
            session()->put('status', '');
            if (!$student) {
                $fieldDisable = "true";
                session()->put('status', 'Student Details not found.');
                return view('admin.plan.add', compact('student', 'fieldDisable'));
            }
        }

        return view('admin.plan.add')->with(compact('student', 'fieldDisable'));
    }


    // Store Plan

    // public function store(Request $request, Plan $plan)
    // {
    //     $request->validate([
    //         'student_id' => 'required',
    //         'plan' => 'required',
    //         'mode_of_payment' => 'required',
    //         'valid_from_date' => 'required|date',
    //         'valid_upto_date' => 'required|date',
    //     ]);
    //     DB::beginTransaction();
    //     try {
    //         $data = $request->all();
    //         $currentDate = now();

    //         $existingPlan = Plan::where('student_id', $request->student_id)
    //             ->where('valid_upto_date', '>=', $currentDate)
    //             ->first();
    //             session()->put('status', '');
    //         if ($existingPlan) {
    //             // active plan already exists
    //             DB::rollBack();
    //             session()->put('status', 'Your plan is already running.');
    //             return view('admin.plan.add');
    //             // dd("Your plan is already running.");
    //             // return redirect()->back()->with('status', 'Your plan is already running.');
    //         } else {
    //             // Create a new plan
    //             Plan::create($data);
    //             session()->forget('pdfDownload');
    //         }
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         session()->put('status', $e->getMessage());
    //         return view('admin.plan.add');
    //         // return redirect()->back()->with('status', $e->getMessage());
    //     }
    //     DB::commit();
    //     session()->put('status', 'Plan added successfully.');
    //     return view('admin.plan.add');
    //     // return redirect()->back()->with('status', 'Plan added successfully.');
    // }

      public function store(Request $request, Plan $plan)
    {
        $request->validate([
            'student_id' => 'required',
            'plan' => 'required',
            'mode_of_payment' => 'required',
            'valid_from_date' => 'required|date',
            'valid_upto_date' => 'required|date',
        ]);
        DB::beginTransaction();
        try {
            $data = $request->all();
            $currentDate = now();

            $existingPlan = Plan::where('student_id', $request->student_id)
                ->where('valid_upto_date', '>=', $currentDate)
                ->first();
                session()->put('status', '');
            if ($existingPlan) {
                // active plan already exists
                DB::rollBack();
                // session()->put('status', 'Student Details not found.');
                dd("Your plan is already running.");
                return redirect()->back()->with('status', 'Your plan is already running.');
            } else {
                // Create a new plan
                Plan::create($data);
                session()->forget('pdfDownload');
            }
        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->back()->with('status', $e->getMessage());
        }
        DB::commit();
        return redirect()->route('plans')->with('status', 'Plan added successfully.');
    }


    // Edit Plan
    public function edit($plan)
    {
        $plan = Plan::find($plan);
        return view('admin.plan.edit')->with(compact('plan'));
    }

    // Update Plan

    public function update(Request $request, Plan $plan)
    {
        $request->validate([
            // 'student_search' => 'required',
            'plan' => 'required',
            'mode_of_payment' => 'required',
            'valid_from_date' => 'required|date',
            'valid_upto_date' => 'required|date',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->all();
            $plan->update($data);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('status', $e->getMessage());
        }

        DB::commit();
        return redirect()->back()->with('status', 'Plan updated successfully.');
    }

    // Delete plan
    public function destroy(Plan $plan)
    {
        DB::beginTransaction();
        try {
            $plan->delete();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('status', 'plan cannot be deleted!');
        }
        DB::commit();
        return redirect()->back()->with('status', 'plan deleted successfully!');
    }

    // Download PDF
    public function downloadPdf()
    {

        $data = [
            'title' => 'Sample PDF',
            'content' => '<p>This is the content of your PDF.</p>',
        ];

        $pdf = PDF::loadView('pdf.studentPlan', $data);
        session()->put('pdfDownload', 'downloaded');
        return $pdf->download('studentPlan.pdf');
        //  return response()->json(['status'=>'success']);
    }
}
