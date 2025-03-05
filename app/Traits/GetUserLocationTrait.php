<?php

namespace App\Traits;

use App\Models\Product;
use App\Models\User;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;

trait GetUserLocationTrait
{
    /**
     * @param  Item  $item
     * @param  string  $orderType
     * @param  string  $code
     */
    public function validateLocation()
    {
        $loginUserRole = Auth::user()->role;
        $locationIds = [];

        if ($loginUserRole->name !== "Super Admin") {
            $locationIds = Auth::user()->LocationIds;
        } else {
            $locationIds = Location::pluck('id');
        }
        
        return $locationIds;
    }

    public function getLocations() {
        $loginUserRole = Auth::user()->role;
        $locations = [];

        if ($loginUserRole->name !== "Super Admin") {
            $locations = Auth::user()->locations;
        } else {
            $locations = Location::join('location_types as types', 'types.id', 'locations.location_type_id')
                                    ->where('types.sale_type', 'Store')
                                    ->select('locations.*')
                                    ->get();
        }
        
        return $locations;
    }

    public function getDissminationLocations() {
        $locations = Location::join('location_types as types', 'types.id', 'locations.location_type_id')
                                ->where('types.sale_type', 'Branch')
                                ->select('locations.*')
                                ->get();
        
        return $locations;
    }

    public function getStoreLocations() {
        $loginUserRole = Auth::user()->role;
        $locations = [];

        if ($loginUserRole->name !== "Super Admin") {
            // $loginUser = $loginUserRole->LocationIds;
            $locations = Location::join('user_location as ul', 'ul.location_id', 'locations.id')
                                    ->join('location_types as types', 'types.id', 'locations.location_type_id')
                                    ->where('ul.user_id','=', Auth::user()->id)
                                    ->where('types.sale_type', 'Store')
                                    ->select('locations.*')
                                    ->get();
                                   
        } else {
            $locations = Location::join('location_types as types', 'types.id', 'locations.location_type_id')
                                    ->where('types.sale_type', 'Store')
                                    ->select('locations.*')
                                    ->get();
        }
        return $locations;
    }

    public function getAllStoreLocations() {
        $locations = [];
        $locations = Location::join('location_types as types', 'types.id', 'locations.location_type_id')
                                ->where('types.sale_type', 'Store')
                                ->select('locations.*')
                                ->get();
        
        return $locations;
    }

    public function getBranchLocations() {
        $loginUserRole = Auth::user();
        $locations = [];

        if ($loginUserRole->role_id !== 1) {
            $loginUser = $loginUserRole->LocationIds;
            $locations = Location::join('location_types as types', 'types.id', 'locations.location_type_id')
                                    ->whereIn('locations.id', $loginUser)->select('locations.*')
                                    ->get();
        } else {
            $locations = Location::join('location_types as types', 'types.id', 'locations.location_type_id')
                                    ->where('types.sale_type', 'Branch')
                                    ->select('locations.*')
                                    ->get();
        }
        return $locations;
    }


    public function POLocations(){
        $loginUserRole = Auth::user()->role;
        $locations = [];

        if ($loginUserRole->name !== "Super Admin") {
            $locations = Location::join('user_location as ul', 'ul.location_id', 'locations.id')
                                    ->join('location_types as types', 'types.id', 'locations.location_type_id')
                                    ->where('ul.user_id','=', Auth::user()->id)
                                    ->where('types.sale_type', 'Branch')
                                    ->get();
        } else {
            $locations = Location::whereHas('locationType', function ($query) {
                            $query->where('sale_type', 'Branch');
                        })->get();
        }       
        return $locations;
    }

    public function getAllLocations(){
        $loginUserRole = Auth::user();
        $locations = [];

        if ($loginUserRole->role_id !== 1) {
            $loginUser = $loginUserRole->LocationIds;
            $locations = Location::join('location_types as types', 'types.id', 'locations.location_type_id')
                                    ->whereIn('locations.id', $loginUser)
                                    ->select('locations.*')
                                    ->get();
        } else {
            $locations = Location::join('location_types as types', 'types.id', 'locations.location_type_id')
                                    ->select('locations.*')
                                    ->get();
        }
        return $locations;
    }
}
