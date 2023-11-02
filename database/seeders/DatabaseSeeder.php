<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => User::ROLE_CLINIC]);
        Role::create(['name' => User::ROLE_DOCTOR]);
        Role::create(['name' => User::ROLE_RECEPTIONIST]);
        Role::create(['name' => User::ROLE_PATIENT]);
        
        $role = Role::firstOrCreate(array(
                'name' => 'Super Admin',
            ));
         if ($role) {
                $isAdmin = User::select('id')->where(array(
                    'email' => 'clinicapp@admin.com',
                ))->first();

                if (!$isAdmin) {
                    $user = User::create(array(
                        'first_name' => 'Super',
                        'last_name' => 'Admin',
                        'name' => 'Super Admin',
                        'email' => 'clinicapp@admin.com',
                        'email_verified_at' => date('Y-m-d h:i:s'),
                        'password' => bcrypt('password'), 
                    ));

                    $user->assignRole($role);
                }
            }
    }
}
