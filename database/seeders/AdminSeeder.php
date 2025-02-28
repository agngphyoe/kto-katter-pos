<?php

namespace Database\Seeders;

use App\Actions\GenerateAutoID;
use App\Constants\PrefixCodeID;
use App\Models\Company;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //company create
        // $company = Company::firstOrNew([
        //     'slug' => 'unity-source'
        // ]);
        // $company->name      = 'Unity Source';
        // $company->prefix    = 'UNS';
        // $company->created_by = 1;
        // $company->save();

        //role create
        $role = Role::firstOrNew([
            'name' => 'Super Admin'
        ]);

        $role->guard_name = 'web';
        $role->save();

        $permissions = Permission::all();

        // Assign all permissions to the 'Admin' role
        $role->permissions()->sync($permissions);

        $is_exist = User::where('name', 'Admin')->exists();

        if (!$is_exist) {
            User::create([
                'name' => 'Admin',
                'user_number' => '000001',
                'slug' => 'admin',
                'created_by' => 1,
                'password' => Hash::make('password'),
                'role_id' => $role->id,
            ]);
        }
    }
}
