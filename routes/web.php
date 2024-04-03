<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Doctor\DoctorController as MainDoctorController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ClinicController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\ReceptionistController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('auth.login');
// });

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/verification',[UserController::class,'resetpswd']);

Route::post('subscription/store',  [UserController::class, 'subscriptionStore'])->name('subscription'); 

Route::group(['middleware' => ['preventBackHistory','auth','verified']], function () {
    
    //Routes available to All Roles
    //dashboard
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('admin_dashboard');
    Route::get('/change-password', [UserController::class, 'changePassword'])->name('change-password');
    Route::post('/change-password', [UserController::class, 'updatePassword'])->name('update-password');
    Route::get('/change-profile', [UserController::class, 'changeProfile'])->name('change-profile');
    Route::post('/update-profile', [UserController::class, 'updateProfile'])->name('update-profile');
    

    //users
    Route::group(['prefix' => 'users'], function() {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('createUser', [UserController::class, 'createUser'])->name('users.createUser');
        Route::post('store', [UserController::class, 'store'])->name('users.store');
        Route::delete('delete', [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('edit/{id}', [UserController::class, 'edit'])->name('users.edit');
        Route::put('update/{id}', [UserController::class, 'update'])->name('users.update');
    });

    

    //Routes available to Super Admin
    //permission
    Route::middleware(['preventBackHistory','role:Super Admin'])->group(function () {
        //Routes available to all users

        // Route::group(['prefix' => 'permissions'], function() {
        //     Route::get('/', [PermissionController::class, 'index'])->name('permissions.index');
        //     Route::get('create', [PermissionController::class, 'create'])->name('permissions.create');
        //     Route::post('store', [PermissionController::class, 'store'])->name('permissions.store');
        //     Route::get('edit/{id}', [PermissionController::class, 'edit'])->name('permissions.edit');
        //     Route::put('update/{id}', [PermissionController::class, 'update'])->name('permissions.update');
        //     Route::delete('delete', [PermissionController::class, 'destroy'])->name('permissions.destroy');
        // });
    
        //roles
        // Route::group(['prefix' => 'roles'], function() {
        //     Route::get('/', [RoleController::class, 'index'])->name('roles.index');
        //     Route::get('create', [RoleController::class, 'create'])->name('roles.create');
        //     Route::post('store', [RoleController::class, 'store'])->name('roles.store');
        //     Route::delete('delete', [RoleController::class, 'destroy'])->name('roles.destroy');
        //     Route::get('edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
        //     Route::put('update/{id}', [RoleController::class, 'update'])->name('roles.update'); 
        // });

        //Hospital
        Route::group(['prefix' => 'hospital'], function() {
            Route::get('/', [ClinicController::class, 'index'])->name('clinics.index');
            Route::get('create', [ClinicController::class, 'create'])->name('clinics.create');
            Route::get('createBranch/{id}', [ClinicController::class, 'createBranch'])->name('clinics.createBranch');
            Route::get('createMainBranch', [ClinicController::class, 'createMainBranch'])->name('clinics.createMainBranch');

            // Route::get('viewBranch/{id}', [ClinicController::class, 'viewBranch'])->name('clinics.viewBranch');
            // Route::get('view/{slug?}', [ClinicController::class, 'show'])->name('clinics.view');
            Route::get('add-branch', [ClinicController::class, 'add_branch'])->name('clinics.add-branch');
            Route::post('store', [ClinicController::class, 'store'])->name('clinics.store');
            Route::delete('delete', [ClinicController::class, 'destroy'])->name('clinics.destroy');
            Route::delete('delete-branch', [ClinicController::class, 'destroyBranch'])->name('branches.destroy');
            Route::get('edit/{id}', [ClinicController::class, 'edit'])->name('clinics.edit');
            Route::put('update/{id}', [ClinicController::class, 'update'])->name('clinics.update'); 
            Route::get('changeStatus', [ClinicController::class, 'changeStatus'])->name('clinics.changeStatus');
            Route::get('export-csv', [ClinicController::class, 'exportCSV'])->name('clinics.exportCSV');
        });


        
    });

      Route::middleware(['role:Super Admin|Hospital'])->group(function () {
     //doctors
        Route::group(['prefix' => 'doctors'], function() {
            Route::get('/', [DoctorController::class, 'index'])->name('doctors.index');
            Route::get('create', [DoctorController::class, 'create'])->name('doctors.create');
            Route::post('store', [DoctorController::class, 'store'])->name('doctors.store');
            Route::delete('delete', [DoctorController::class, 'destroy'])->name('doctors.destroy');
            Route::get('view/{id}', [DoctorController::class, 'show'])->name('doctors.view');
            Route::get('edit/{id}', [DoctorController::class, 'edit'])->name('doctors.edit');
            Route::put('update/{id}', [DoctorController::class, 'update'])->name('doctors.update'); 
            Route::get('changeStatus', [DoctorController::class, 'changeStatus'])->name('doctors.changeStatus');
            Route::get('export-csv', [DoctorController::class, 'exportCSV'])->name('doctors.exportCSV');
            Route::get('/test', [UserController::class, 'test'])->name('test');

        });
    });

        Route::middleware(['role:Super Admin|Hospital'])->group(function () {
        //receptionist
        Route::group(['prefix' => 'staff'], function() {
            Route::get('/', [ReceptionistController::class, 'index'])->name('receptionists.index');
            Route::get('create', [ReceptionistController::class, 'create'])->name('receptionists.create');
            Route::post('store', [ReceptionistController::class, 'store'])->name('receptionists.store');
            Route::delete('delete', [ReceptionistController::class, 'destroy'])->name('receptionists.destroy');
            Route::get('view/{id}', [ReceptionistController::class, 'show'])->name('receptionists.view');
            Route::get('edit/{id}', [ReceptionistController::class, 'edit'])->name('receptionists.edit');
            Route::put('update/{id}', [ReceptionistController::class, 'update'])->name('receptionists.update'); 
            Route::get('changeStatus', [ReceptionistController::class, 'changeStatus'])->name('receptionists.changeStatus');
            Route::get('export-csv', [ReceptionistController::class, 'exportCSV'])->name('receptionists.exportCSV');
        });
    });
    // Routes available to super admin and doctor
    Route::middleware(['role:Super Admin|Doctor|Staff|Hospital'])->group(function () {
         
        //patients
        Route::group(['prefix' => 'patients'], function() {
            Route::get('/', [PatientController::class, 'index'])->name('patients.index');
            Route::get('create', [PatientController::class, 'create'])->name('patients.create');
            Route::post('store', [PatientController::class, 'store'])->name('patients.store');
            Route::delete('delete', [PatientController::class, 'destroy'])->name('patients.destroy');
            Route::get('view/{id}', [PatientController::class, 'show'])->name('patients.view');
            Route::get('edit/{id}', [PatientController::class, 'edit'])->name('patients.edit');
            Route::put('update/{id}', [PatientController::class, 'update'])->name('patients.update'); 
            Route::get('changeStatus', [PatientController::class, 'changeStatus'])->name('patients.changeStatus');
            Route::get('export-csv', [PatientController::class, 'exportCSV'])->name('patients.exportCSV');
            Route::post('fetchDoctors', [PatientController::class, 'fetchDoctors'])->name('patients.fetchDoctors');


        });
        Route::middleware(['role:Doctor|Staff|Hospital','preventBackHistory'])->group(function () {
            Route::get('/appointments', [MainDoctorController::class, 'appointments'])->name('appointments.index');
            Route::get('/all_appointment', [MainDoctorController::class, 'all_appointment'])->name('all_appointment');
            Route::get('/todays_appointment', [MainDoctorController::class, 'todays_appointment'])->name('todays_appointment');
            Route::get('/upcoming_appointment', [MainDoctorController::class, 'upcoming_appointment'])
            ->name('upcoming_appointment');
            Route::get('/past_appointment', [MainDoctorController::class, 'past_appointment'])
            ->name('past_appointment');
            Route::post('/appointment_calender', [MainDoctorController::class, 'calendarEvents'])->name('appointment_calender');
            Route::get('settingsCreate', [MainDoctorController::class, 'settingsCreate'])->name('settings.create');
            Route::post('settingsStore', [MainDoctorController::class, 'settingsStore'])->name('settings.store');
            Route::get('edit/{id}', [MainDoctorController::class, 'edit'])->name('all-appointments.edit');
            Route::put('update/{id}', [MainDoctorController::class, 'update'])->name('all-appointments.update');
            Route::delete('delete', [MainDoctorController::class, 'destroy'])->name('all-appointments.destroy');
            Route::get('changeStatus', [MainDoctorController::class, 'changeStatus'])->name('appointments.changeStatus');
            Route::get('/mailview', [MainDoctorController::class, 'mailview'])->name('mailview');
            Route::post('/fetchDoctortimeslots', [MainDoctorController::class, 'fetchDoctortimeslots'])->name('appointments.fetchDoctortimeslots');

        });
        });

        Route::middleware(['role:Doctor|Hospital|Super Admin|Patient', 'preventBackHistory'])->group(function () {
            Route::get('view/{id}', [DoctorController::class, 'show'])->name('doctors.view');
        });


        Route::middleware(['role:Patient', 'preventBackHistory'])->group(function () {
            Route::get('/doctor', [DoctorController::class, 'doctorsListing'])->name('doctorslisting.index');
            Route::get('/hospitals', [DoctorController::class, 'clinicsListing'])->name('clinicsListing.index');
            Route::get('/patient_appointments', [MainDoctorController::class, 'patientAppointments'])->name('patient_appointments.index');
            Route::post('/patient_appointment_calender', [MainDoctorController::class, 'patientcalendarEvents'])->name('patient_appointment_calender');
            Route::post('fetchDoctors', [MainDoctorController::class, 'fetchDoctors'])->name('appointments.fetchDoctors');
            Route::post('fetchTimeSlots', [MainDoctorController::class, 'fetchTimeSlots'])->name('appointments.fetchTimeSlots');
            Route::post('fetchTimeSlotsDoctor', [MainDoctorController::class, 'fetchTimeSlotsDoctor'])->name('appointments.fetchTimeSlotsDoctor');
            Route::get('/all_patient_appointment', [MainDoctorController::class, 'all_patient_appointment'])->name('all_patient_appointment');
            Route::get('/todays_patient_appointment', [MainDoctorController::class, 'todays_patient_appointment'])->name('todays_patient_appointment');
            Route::get('/upcoming_patient_appointment', [MainDoctorController::class, 'upcoming_patient_appointment'])
            ->name('upcoming_patient_appointment');
            Route::get('/past_patient_appointment', [MainDoctorController::class, 'past_patient_appointment'])
            ->name('past_patient_appointment');
            Route::delete('patient-delete', [MainDoctorController::class, 'destroyPatient'])->name('all-patient-appointments.destroy');
            Route::get('fetchClinics', [MainDoctorController::class, 'fetchClinics'])->name('patient.fetchClinics');
            Route::get('patientClinicAppointments', [MainDoctorController::class, 'patientClinicAppointments'])->name('patient.BookClinic');
        });


    Route::middleware(['role:Super Admin|Patient', 'preventBackHistory'])->group(function(){
    Route::group(['prefix' => 'hospital'], function() {
    Route::get('view/{slug?}', [ClinicController::class, 'show'])->name('clinics.view');
    Route::get('viewBranch/{id}', [ClinicController::class, 'viewBranch'])->name('clinics.viewBranch');
});
});
 

Route::get('getuser_status',[UserController::class, 'getUserStatus'])->name('user_status')->middleware('preventBackHistory');
});
 
require __DIR__.'/auth.php';
