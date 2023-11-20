<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;
use App\Models\ReceptionistDetails;
class ReceptionistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ReceptionistRole = Role::firstOrCreate(array(
            'name' => 'Receptionist',
        ));
     if ($ReceptionistRole) {
            $isReceptionist = User::select('id')->where(array(
                'email' => 'rachel@receptionist.com',
            ))->first();

            if (!$isReceptionist) {
                $Receptionist = User::create(array(
                    'first_name' => 'Rachel',
                    'last_name' => 'salio',
                    'name' => 'Receptionist',
                    'email' => 'rachel@receptionist.com',
                    'email_verified_at' => date('Y-m-d h:i:s'),
                    'password' => bcrypt('password'), 
                ));

                $Receptionist->assignRole($ReceptionistRole);

                ReceptionistDetails::create([
                 'user_id'=>$Receptionist->id,
                 'clinic_id'=>1,
                 'gender'=>'female',
                 'birth_date'=>'1970-11-01',
                 'qualification'=>'12th',
                 'experience'=>'abc',
                 'status'=>1,
                 'latitude'=>'0',
                 'logitude'=>'0',
                ]);
            }
        }
    }
}
