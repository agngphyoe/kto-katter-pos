<?php

namespace App\Imports;

use App\Constants\PrefixCodeID;
use App\Models\Customer;
use App\Models\Division;
use App\Models\Township;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;


class CustomerImport implements ToModel, WithHeadingRow
{
    use Importable;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    private $success = true;
    public function model(array $row)
    {
        if (!($row['name'] == null || $row['phone'] == null || $row['township'] == null || $row['division'] == null || $row['contact_name'] == null || $row['contact_phone'] == null)) {
            try {
                $result = DB::transaction(function () use ($row) {
                    $is_exists = Customer::wherePhone($row['phone'])->orWhere('contact_phone', $row['contact_phone'])->first();
                    if ($is_exists) {
                        throw ValidationException::withMessages(['code' => "Customer with phone {$row['phone']}  or contact phone {$row['contact_phone']} already exists."]);
                    }

                    $division = Division::firstOrCreate(['name' => $row['division']]);

                    $township = Township::firstOrCreate([
                        'name' => $row['township'],
                        'division_id' => $division->id,
                    ]);

                    $exist_record = Customer::latest('id')->first();
                    $user_number = getAutoGenerateID(PrefixCodeID::CUSTOMER, $exist_record?->user_number);

                    Customer::create([
                        'name'      => $row['name'],
                        'user_number'      => $user_number,
                        'phone'     => $row['phone'],
                        'address'   => $row['address'] ?? null,
                        'township_id'  => $township->id,
                        'division_id'  => $division->id,
                        'contact_name' => $row['contact_name'],
                        'contact_phone' => $row['contact_phone'],
                        'is_new'    => 0,
                    ]);
                }, 5);
                return $result;
            } catch (ValidationException $e) {

                $this->success = false;

                throw $e;
            } catch (\Exception $e) {

                Log::error('An exception occurred: ' . $e->getMessage(), ['exception' => $e]);
                $this->success = false;

                throw $e;
            }
        } else {
            throw ValidationException::withMessages(['code' => "Some missing data in import file."]);
        }
    }

    public function getSuccess()
    {
        return $this->success;
    }
}
