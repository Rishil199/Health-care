<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;
use App\Models\DoctorDetails;
class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $DoctorRole = Role::firstOrCreate(array(
            'name' => 'Doctor',
        ));
     if ($DoctorRole) {
            $isDoctor= User::select('id')->where(array(
                'email' => 'james@doctor.com',
            ))->first();

            if (!$isDoctor) {
                $Doctor = User::create(array(
                    'first_name' => 'james',
                    'last_name' => 'smith',
                    'name' => 'Doctor',
                    'email' => 'james@doctor.com',
                    'email_verified_at' => date('Y-m-d h:i:s'),
                    'password' => bcrypt('password'), 
                ));

                $Doctor->assignRole($DoctorRole);

                DoctorDetails::create([
                    'user_id'=>$Doctor->id,
                    'clinic_id'=>1,
                    'address'=>'abc',
                    'latitude'=>'0',
                    'logitude'=>'0',
                    'birth_date'=>'1981-01-11',
                    'gender'=>'Male',
                    'degree'=>'mbbs',
                    'experience'=>'one year',
                    'status'=>1
                ]);
            }
        }
    }
}
