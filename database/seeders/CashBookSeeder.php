<?php

namespace Database\Seeders;

use App\Models\AccountType;
use App\Models\Bank;
use App\Models\User;
use Illuminate\Database\Seeder;

class CashBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bank = Bank::firstOrNew([
            'bank_name' => 'Cash'
        ]);

        $bank->account_name      = 'Unity Source';
        $bank->created_by        = User::first()->id;

        $bank->save();

        $account_types = [
            'Income',
            'Expense',
            'Others',
        ];

        foreach ($account_types as $type) {

            $is_exist = AccountType::whereName($type)->exists();

            if (!$is_exist) {

                AccountType::create([
                    'name' => $type,
                    'created_by' => User::first()->id
                ]);
            }
        }
    }
}
