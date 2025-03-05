<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Role;

class ADDPosReceivableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionGroups = [
            [
                'name' => 'POS',
                'permissions' => [
                    'pos-receivable-list',
                    'pos-receivable-details',
                    'pos-receivable-change-status',
                ]
            ],
        
        ];

        foreach ($permissionGroups as $group) {

            $newGroup = PermissionGroup::firstOrCreate([
                'name' => $group['name'],
            ]);

            foreach ($group['permissions'] as $permissionName) {

                Permission::firstOrCreate([
                    'name' => $permissionName,
                    'guard_name' => 'web',
                    'permission_group_id' => $newGroup->id,
                ]);
            }
        }

        $permissions = Permission::all();
        $role = Role::where('name', 'Super Admin')->first();

        $role->permissions()->sync($permissions);
    }
}
