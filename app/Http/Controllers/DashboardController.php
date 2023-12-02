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
        $currentDate = date('Y-m-d');
        $total['totalActivePlans'] = Plan::whereDate('valid_upto_date', '>=', $currentDate)
            // ->whereDate('valid_upto_date', '<=', now()->addDays(5))
            ->count();

        $plans = Plan::with('student')
            ->whereDate('plans.valid_upto_date', '>=', Carbon::now())
            ->whereDate('plans.valid_upto_date', '<=', Carbon::now()->addDays(5));
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
        return view('dashboard')->with(compact('total', 'plans'));
    }
}
