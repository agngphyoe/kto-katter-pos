<?php

namespace App\Http\Controllers\API;

use App\Actions\HandlerResponse;
use App\Constants\PrefixCodeID;
use App\Events\CustmoerCreatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\CustomerStoreRequest;
use App\Http\Requests\API\TownshipByDivisionRequest;
use App\Http\Resources\CustomerchartCollection;
use App\Http\Resources\CustomerCollection;
use App\Http\Resources\DivisionCollection;
use App\Http\Resources\TownshipCollection;
use App\Models\Customer;
use App\Models\Division;
use App\Models\Address;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomerAPIController extends Controller
{
    use HandlerResponse;

    public function index(Request $request)
    {
        // $cutomers = Customer::where(function ($query) use ($request) {
        //     $request->has('name')
        //         && $query->where('name', 'like', '%' . $request->name . '%');

        //     if ($request->has('division') && $request->has('township') && $request->has('filter')) {
        //         $query->Where('division_id', '=',  $request->division)
        //             ->where('township_id', '=',  $request->township)->where(function ($query) use ($request) {

        //                 $columns = ['name', 'user_number', 'phone', 'email'];
        //                 foreach ($columns as $column) {
        //                     $query->orWhere($column, 'LIKE', '%' . $request->filter . '%')
        //                         ->where(function ($query) use ($request) {
        //                             $request->has('division') && $query->where('division_id', '=',  $request->division);
        //                             $request->has('township') && $query->where('township_id', '=',  $request->township);
        //                         });
        //                 }
        //                 $query->orWhereHas('division', function ($query) use ($request) {

        //                     $query->where('name', 'Like', '%' . $request->filter . '%');
        //                 })->orWhereHas('township', function ($query) use ($request) {

        //                     $query->where('name', 'Like', '%' . $request->filter . '%');
        //                 });
        //             });
        //     } else if ($request->has('filter') && ($request->has('division') || $request->has('township'))) {
        //         $columns = ['name', 'user_number', 'phone', 'email'];
        //         foreach ($columns as $column) {
        //             $query->orWhere($column, 'LIKE', '%' . $request->filter . '%')
        //                 ->where(function ($query) use ($request) {
        //                     $request->has('division') && $query->where('division_id', '=',  $request->division);
        //                     $request->has('township') && $query->where('township_id', '=',  $request->township);
        //                 });
        //         }
        //         $query->orWhereHas('division', function ($query) use ($request) {

        //             $query->where('name', 'like', '%' . $request->filter . '%');
        //         })->orWhereHas('township', function ($query) use ($request) {

        //             $query->where('name', 'like', '%' . $request->filter . '%');
        //         });
        //     } else if ($request->has('filter') && !($request->has('division')) && !($request->has('township'))) {
        //         $columns = ['name', 'user_number', 'phone', 'email'];
        //         foreach ($columns as $column) {
        //             $query->orWhere($column, 'LIKE', '%' . $request->filter . '%');
        //             //->where(function ($query) use ($request) {
        //             //    $request->has('division') && $query->where('division_id', '=',  $request->division);
        //             //    $request->has('township') && $query->where('township_id', '=',  $request->township);
        //             //});
        //         }
        //         $query->orWhereHas('division', function ($query) use ($request) {

        //             $query->where('name', 'like', '%' . $request->filter . '%');
        //         })->orWhereHas('township', function ($query) use ($request) {

        //             $query->where('name', 'like', '%' . $request->filter . '%');
        //         });
        //     } else {
        //         $query->where(function ($query) use ($request) {
        //             $request->has('division') && $query->where('division_id', '=',  $request->division);
        //             $request->has('township') && $query->where('township_id', '=',  $request->township);
        //         });
        //     }


        //     $request->has('user_number')
        //         && $query->where('user_number', 'like', '%' . $request->user_number . '%');
        // })->where('createable_id', auth()->user()->id)->orderByDesc('created_at');       
        if($request->search){
            $customers = Customer::where('name', 'like', '%' . $request->search . '%')
                                    ->paginate(10);

        }elseif($request->division && $request->township){
            $customers = Customer::where('division', $request->division)
                                    ->where('township', $request->township)
                                    ->paginate(10);

        }elseif($request->division){
            $customers = Customer::where('division', $request->division)
                                    ->paginate(10); 
                                           
        }else{
            $customers = Customer::paginate(10);
        } 
            
        return $this->responseCollection(data: new CustomerCollection($customers));
    }



    public function peryearfunction(Request $request)
    {
        //$customer_count = DB::Select('MONTHNAME(created_at),');
        $year = $request->has('year') ? $request->year : now()->year;
        $results = Customer::selectRaw('MONTHNAME(created_at) as month, count(*) as count')
            ->whereYear('created_at', $year)->where('createable_id', auth()->user()->id)
            ->groupBy(DB::raw('MONTHNAME(created_at)'))->get();
        return $this->responseCollection(data: new CustomerchartCollection($results));
    }

    public function per_week_chart_data(Request $request)
    {
        $month = $request->has('month') ? $request->month : now()->month;
        $year = $request->has('year') ? $request->year : now()->year;

        $results = Customer::selectRaw('FLOOR((DAYOFMONTH(Date(created_at)) - 1) / 7) + 1 as month, count(*) as count')
            ->whereMonth('created_at', $month)->whereYear('created_at', $year)
            ->where('createable_id', auth()->user()->id)
            ->groupBy(DB::raw('month'))->get();
        return $this->responseCollection(data: new CustomerchartCollection($results));
    }

    public function newcustomer(Request $request)
    {
        $cutomers = Customer::where('is_new', '=', 1)
                             ->where(function ($query) use ($request) {
                                    $request->has('division') && $query->where('division_id', '=',  $request->division);
                                    $request->has('township') && $query->where('township_id', '=',  $request->township);
                                });
        return $this->responseCollection(data: new CustomerCollection($cutomers->paginate(10)));
    }

    public function customercount(Request $request)
    {
        $customers = Customer::where('createable_id', auth()->user()->id)->where(function ($query) use ($request) {
            $request->has('division') && $query->where('division_id', '=',  $request->division);
            $request->has('township') && $query->where('township_id', '=',  $request->township);
        });
        $customercount = $customers->count();
        return $customercount;
    }

    public function store(CustomerStoreRequest $request)
    {  
        $exist_record = Customer::latest()->first();

        $existingPhone = Customer::where('phone', $request->phone)
                                ->first();
    
        if ($existingPhone) {
            return $this->responseUnprocessable(
                status_code: 422,
                message: "This Customer phone is Already exists"
            );
        }
        $user_number = getAutoGenerateID(PrefixCodeID::CUSTOMER, $exist_record?->user_number,);

        $request['user_number'] = $user_number;
        $customer = Customer::create($request->all());

        if ($customer) {
            event(new CustmoerCreatedEvent($customer));
            return $this->responseSuccessMessage(message: 'Successfully Created.', status_code: 201);
        }
    }

    public function updatestafflocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'division_id' => 'required',
            'township_id' => 'required',
        ]);

        
        if ($validator->fails()) {
            return $this->responseUnprocessable(
                status_code: 422,
                message: $validator->errors());
        }

        
        $staff = Staff::where('id', auth()->user()->id)->first();
       
        // Check if staff record exists
        if (!$staff) {
            return $this->responseUnprocessable(message : 'Staff not found.', status_code: 404 );
        }

        if ($staff->division_id != $request->division_id || $staff->township_id != $request->township_id) {
            $staff->update([
                'division_id' => $request->division_id,
                'township_id' => $request->township_id
            ]);

            return $this->responseSuccessMessage(message: 'Successfully Created.', status_code: 201);
        }

        // Return success message if no changes were made
        return $this->responseSuccessMessage(message: 'Has no changed.', status_code: 201);
    }

    public function getCustomerForDropdown(Request $request)
    {
        $customers = Customer::select('name', 'id', 'phone', 'address')->where('createable_id', auth()->user()->id)->get();
        return $this->responseCollection(data: $customers);
    }


    public function getDivisions()
    {
        $divisions = Address::where('type', 'state')
                            ->orderBy('name', 'asc')
                            ->get();
        
        return $this->responseCollection(data: new DivisionCollection($divisions));
    }

    public function getTownshipsByDivision(TownshipByDivisionRequest $request)
    { 
        $division = Address::where('code', $request->division_code)
                            ->first();

        if ($division) {

            $townships = Address::where('code', 'like', '%'. $request->division_code . '%')
                            ->where('type', 'township')
                            ->orderBy('name', 'asc')
                            ->get();

            return $this->responseCollection(data: new TownshipCollection($townships));
        }

        return $this->responseUnprocessable(message: 'Division does not exist.');
    }
}
