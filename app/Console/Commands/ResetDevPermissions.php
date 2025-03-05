<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class ResetDevPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:remove-service-modules';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes service-module-specific permissions while keeping dev permissions intact';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     parent::__construct();
    // }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Removing service-module permissions...');

        $serviceModulePermissions = [
            [
                'name' => 'Service Settings',
                'permissions' => [
                    'service-settings-create',
                    'service-settings-edit',
                    'service-settings-delete',
                    'service-settings-details',
                ],
            ],
            [
                'name' => 'Spare Parts',
                'permissions' => [
                    'spare-parts-list',
                    'spare-parts-create',
                    'spare-parts-edit',
                    'spare-parts-delete',
                    'spare-parts-details',
                    'spare-parts-price-change',
                ],
            ],
            [
                'name' => 'Service Charges',
                'permissions' => [
                    'service-charges-list',
                    'service-charges-create',
                    'service-charges-edit',
                    'service-charges-delete',
                    'service-charges-details',
                    'service-charges-price-change',
                ],
            ],
            [
                'name' => 'Service Receive Form',
                'permissions' => [
                    'service-receive-form-list',
                    'service-receive-form-create',
                    'service-receive-form-edit',
                    'service-receive-form-delete',
                    'service-receive-form-details',
                    'service-receive-form-export',
                ],
            ],
        ];

        $permissions = collect($serviceModulePermissions)->pluck('permissions')->flatten()->toArray();
        $groupName = collect($serviceModulePermissions)->pluck('name')->toArray();

        if (!empty($groupName)) {
            DB::table('permissions')->whereIn('name', $permissions)->delete();

            DB::table('permission_groups')->whereIn('name', $groupName)->delete();
            $this->info('Service-module permissions removed successfully.');
        } else {
            $this->info('No permissions found to remove.');
        }
    }
}
