<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $total['student'] = Student::count();
        // $total['plans'] = Plan::count();
        // Count total active plans
        $total['totalActivePlans'] = Plan::whereDate('valid_upto_date', '>=', now())
            ->whereDate('valid_upto_date', '<=', now()->addDays(5))
            ->count();

        $plans = Plan::with('student')
            ->whereDate('plans.valid_upto_date', '>=', Carbon::now())
            ->whereDate('plans.valid_upto_date', '<=', Carbon::now()->addDays(5));

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
        return view('dashboard')->with(compact('total', 'plans'));
    }
}
