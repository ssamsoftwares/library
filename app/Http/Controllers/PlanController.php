<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Response;
use Carbon\Carbon;

class PlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:plan-list|plan-view|plan-create|plan-edit|plan-delete', ['only' => ['view', 'index']]);
        $this->middleware('permission:plan-view', ['only' => ['view']]);
        $this->middleware('permission:plan-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:plan-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:plan-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $plans = Plan::with('student');
        $search = $request->input('search');

        if ($search && Carbon::hasFormat($search, 'd-m-Y')) {
            $formattedSearchDate = Carbon::createFromFormat('d-m-Y', $search)->format('Y-m-d');
            $plans->where(function ($query) use ($formattedSearchDate) {
                $query->orWhere('valid_from_date', 'like', '%' . $formattedSearchDate . '%')
                    ->orWhere('valid_upto_date', 'like', '%' . $formattedSearchDate . '%');
            });
        } elseif ($search) {
            $plans->where(function ($query) use ($search) {
                $query->where('plan', 'like', '%' . $search . '%')
                    ->orWhere('mode_of_payment', 'like', '%' . $search . '%')
                    ->orWhereHas('student', function ($studentSubquery) use ($search) {
                        $studentSubquery->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%')
                            ->orWhere('aadhar_number', 'like', '%' . $search . '%')
                            ->orWhere('personal_number', 'like', '%' . $search . '%');
                    });
            });
        }

        $plans = $plans->orderBy('created_at', 'DESC')->paginate(10);

        return view('admin.plan.all', compact('plans'));
    }

    //Asign Plan From
    public function create(Request $request)
    {
        $student = null;
        $assignButton = "disabled";
        $pdfDownloadBtn = "disabled";
        if (!empty($request->input('student_search'))) {
            $student = Student::where('personal_number', $request->input('student_search'))->orWhere('aadhar_number', $request->input('student_search'))->orWhere('email', $request->input('student_search'))->first();
            if ($student == NULL) {
                return redirect()->back()->with("status", "Student Details not found.")->withInput();
            } else {
                $assignButton = "";
                return view('admin.plan.add', compact('student', 'assignButton', 'pdfDownloadBtn'));
            }
        } else {
            if ($request->has('student_search') && empty($request->input('student_search'))) {
                return redirect()->back()->with("status", "Please input search query.")->withInput();
            }
            return view('admin.plan.add', compact('student', 'assignButton', 'pdfDownloadBtn'));
        }
    }


    public function view($plan)
    {
        $plan = Plan::with('student')->find($plan);
        $studentId = $plan->student->id;

        $currentDate = Carbon::now();
        $activePlans = Plan::where('student_id', $studentId)
            ->where('valid_upto_date', '>=', $currentDate->format('Y-m-d'))
            ->get();

        $expiredPlans = Plan::where('student_id', $studentId)
            ->where('valid_upto_date', '<', $currentDate->format('Y-m-d'))
            ->get();

        return view('admin.plan.view')->with(compact('plan', 'activePlans', 'expiredPlans'));
    }

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
            $currentDate = date('Y-m-d');
            $plan = NULL;
            $existingPlan = Plan::where('student_id', $request->student_id)
                ->where('valid_upto_date', '>=', $currentDate)
                ->first();

            if ($existingPlan) {
                DB::rollBack();
                $assignButton = "";
                $pdfDownloadBtn = "disabled";
                return redirect()->back()->with(["status" => "Your plan is already running.", "pdfDownloadBtn" => $pdfDownloadBtn, "assignButton" => $assignButton, "plan_id" => $existingPlan->id])->withInput();
            } else {
                $plan = Plan::create($data);
            }
        } catch (Exception $e) {
            DB::rollBack();
            $assignButton = "disabled";
            $pdfDownloadBtn = "disabled";
            return redirect()->back()->withInput()->with(["status", $e->getMessage(), "pdfDownloadBtn" => $pdfDownloadBtn, "assignButton" => $assignButton]);
        }
        DB::commit();
        $assignButton = "disabled";
        $pdfDownloadBtn = "";
        return redirect()->back()->with(["status" => "Plan added successfully.", "pdfDownloadBtn" => $pdfDownloadBtn, "assignButton" => $assignButton, "plan_id" => $plan->id]);
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

    // Download Pdf
    public function downloadPdf($id)
    {
        $plan = Plan::with('student')->find($id);
        if (!$plan) {
            return redirect()->back()->with('status', 'Plan not found or an error occurred.');
        }

        $data = [
            'title' => 'Sample PDF',
            'content' => '<p>This is the content of your PDF.</p>',
            'plan' => $plan,
        ];

        $pdf = PDF::loadView('pdf.studentPlan', $data);
        // Generate the PDF
        $pdfFile = $pdf->output();

        return response()->stream(
            function () use ($pdfFile) {
                echo $pdfFile;
            },
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="k3Library_student.pdf"',
            ]
        );
    }


    // demo pdf testing
    public function generatePdf()
    {
        $pdf = PDF::loadView('pdf.demo');

        return $pdf->download('demo.pdf');
    }
}
