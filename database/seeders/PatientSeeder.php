<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;
use App\Models\PatientDetails;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $patientRole = Role::firstOrCreate(array(
            'name' => 'Patient',
        ));
     if ($patientRole) {
            $isPatient = User::select('id')->where(array(
                'email' => 'john@doctor.com',
            ))->first();

            if (!$isPatient) {
                $Patient = User::create(array(
                    'first_name' => 'john',
                    'last_name' => 'smith',
                    'name' => 'Patient',
                    'email' => 'john@doctor.com',
                    'email_verified_at' => date('Y-m-d h:i:s'),
                    'password' => bcrypt('password'), 
                ));

                $Patient->assignRole($patientRole);
                
                PatientDetails::create([
                    'user_id'=>$Patient->id,
                    'clinic_id'=>1,
                    'doctor_id'=>1,
                    'gender'=>'male',
                    'admit_date'=>'2015-11-1',
                    'disease_name'=>'diabetis',
                    'prescription'=>'abc',
                    'allergies'=>'syz',
                    'illness'=>'no',
                    'exercise'=>'no',
                    'alchohol_consumption'=>'no',
                    'diet'=>'yes',
                    'smoke'=>'no',
                    'address'=>'avx',
                    'latitude'=>'0',
                    'logitude'=>'0',
                    'patient_number'=>7878894571,
                    'receptionist_id'=>1

                ]);
            }
        }
    }
}
