<?php

namespace App\Http\Controllers\API;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Actions\HandlerResponse;
use App\Http\Controllers\Controller;
use App\Traits\GetUserLocationTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\LocationResource;

class LocationAPIController extends Controller
{

    use HandlerResponse, GetUserLocationTrait;

    public function locationTo() 
    {
       
         $locations = $this->getAllStoreLocations();
         
        return $this->responseCollection(data:  LocationResource::collection($locations));
    }

    public function locationFrom()  {
       
        $locations = $this->getWholeSaleLocations();

       return $this->responseCollection(data:   LocationResource::collection($locations));
   }
}
