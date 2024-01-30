<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;
use App\Models\ClinicDetails;
class ClinicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clinicRole = Role::firstOrCreate(array(
            'name' => 'Clinic',
        ));
      
     if ($clinicRole) {
            $isclinic = User::select('id')->where(array(
                'email' => 'ssd@clinic.com',
            ))->first();

            if (!$isclinic) {
                $clinic = User::create(array(
                    'first_name' => 'cooper',
                    'last_name' => 'hospital',
                    'name' => 'Clinic',
                    'email' => 'cooper@clinic.com',
                    'email_verified_at' => date('Y-m-d h:i:s'),
                    'password' => bcrypt('password'), 
                ));

                $clinic->assignRole($clinicRole);

                ClinicDetails::create([
                  'user_id'=>$clinic->id,
                  'clinic_id'=>1,
                   'address' =>'aaa',
                   'latitude'=>'0',
                   'logitude'=>'0',
                   'is_main_branch'=>'0',
                   'status'=>1

                ]);
            }
        }
       
}
    }

