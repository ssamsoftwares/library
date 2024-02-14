<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StudentAuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\UserController;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

if (env('APP_ENV') === 'production') {
    URL::forceSchema('https');
}

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/demo-pdf', function () {
    return view('pdf.testPdf');
});

Route::get('/show-demo-pdf', function () {
    return view('pdf.demo');
});

Route::get('/demo-pdf-download', [PlanController::class, 'generatePdf'])->name('generatePdf');



Route::group(['middleware' => ['auth', '\Spatie\Permission\Middleware\RoleMiddleware:superadmin']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});

Route::middleware(['auth', 'verified'])->group(function () {


    // dashboard
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // User Profile
    Route::get('/logout', function (Request $request) {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update-password', [ProfileController::class, 'update_password'])->name('profile.update_password');


    // student Routes

    Route::get('/students', [StudentController::class,  'index'])->name('students');
    Route::get('/view-students/{student?}', [StudentController::class,  'view'])->name('student.view');

    Route::get('/add-student', [StudentController::class, 'create'])->name('student.add');
    Route::post('/add-student', [StudentController::class, 'store'])->name('student.store');

    Route::get('/edit-student/{student}', [StudentController::class, 'edit'])->name('student.edit');
    Route::post('/edit-student/{student?}', [StudentController::class, 'update'])->name('student.update');

    Route::get('/delete-student/{student?}', [StudentController::class, 'destroy'])->name('student.delete');

    Route::get('/student-status-update/{id}', [StudentController::class, 'studentStatusUpdate'])->name('student.statusUpdate');

    Route::post('/student-update-password', [StudentController::class, 'update_password'])->name('student.update_password');

    // BULK UPLOADED STUDENTS ROUTE

    Route::get('/bulk-upload-student', [StudentController::class, 'bulkUploadStudents'])->name('student.bulkUploadStudents');

    Route::get('/bulk-upload-student-view/{bulkUploadStudent?}', [StudentController::class, 'bulkUploadStudentsView'])->name('student.bulkUploadStudentsView');

    Route::get('/import-student', [StudentController::class, 'importFileView'])->name('student.importFileView');

    Route::post('/import-student', [StudentController::class, 'import'])->name('student.import');

    Route::get('/download-sampleCsv-student', [StudentController::class, 'downloadSampleCsv'])->name('student.downloadSampleCsv');

    Route::get('/uploaded-student-edit/{bulkUploadStudent?}', [StudentController::class, 'bulkUploadStudentsEdit'])->name('student.bulkUploadStudentsEdit');

    Route::post('/uploaded-student-edit/{bulkUploadStudent?}', [StudentController::class, 'bulkUploadStudentsUpdate'])->name('student.bulkUploadStudentsUpdate');

    // asign plan

    Route::get('/plans', [PlanController::class, 'index'])->name('plans');
    Route::get('/view-plans/{plan?}', [PlanController::class, 'view'])->name('plan.view');

    Route::get('/add-plan', [PlanController::class, 'create'])->name('plan.add');
    Route::post('/add-plan', [PlanController::class, 'store'])->name('plan.store');

    Route::get('/edit-plan/{plan?}', [PlanController::class, 'edit'])->name('plan.edit');
    Route::post('/edit-plan/{plan?}', [PlanController::class, 'update'])->name('plan.update');

    Route::get('/delete-plan/{plan?}', [PlanController::class, 'destroy'])->name('plan.delete');

    Route::get('/download-pdf/{id?}', [PlanController::class, 'downloadPdf'])->name('plan.downloadPdf');
});
// Admin Routes
// Route::middleware(['auth', 'role:admin'])->group(function () {
// });
Route::get('/terms', function () {
    return view('terms');
})->name('terms');


// STUDENT AUTH ROUTES
Route::get('student-login', [StudentAuthController::class, 'studentLoginView'])->name('student.login');
Route::post('student-login', [StudentAuthController::class, 'studentLogin'])->name('student.loginPost');

Route::get('student-forgot-password', [StudentAuthController::class, 'forgotPassword'])
    ->name('student.passwordRequest');

Route::post('student-forgot-password', [StudentAuthController::class, 'forgotPasswordStore'])
    ->name('student.forgotPasswordStore');

Route::get('student-reset-password/{token?}', [StudentAuthController::class, 'resetPassword'])
    ->name('student.passwordReset');

Route::post('student-reset-password', [StudentAuthController::class, 'resetPasswordStore'])
    ->name('student.resetPasswordStore');

Route::get('student-logout', [StudentAuthController::class, 'studentLogout'])->name('student.logout');

// STUDENT PANEL ROUTES
Route::middleware(['student'])->group(function () {
    Route::get('student-dashboard', [StudentDashboardController::class, 'studentdashboard'])->name('student.dashboard');
    Route::get('student-profile', [StudentDashboardController::class, 'studentProfile'])->name('student.profile');

    Route::get('student-profile-edit', [StudentDashboardController::class, 'studentProfileEdit'])->name('student.studentProfileEdit');

    Route::post('student-profile-update', [StudentDashboardController::class, 'studentProfileUpdate'])->name('student.studentProfileUpdate');

    Route::get('plan-details', [StudentDashboardController::class, 'planDetails'])->name('student.planDetails');
});



require __DIR__ . '/auth.php';
