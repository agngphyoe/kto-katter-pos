<?php

namespace App\Http\Controllers\API;

use App\Actions\HandlerResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompanySettingsCollection;
use App\Http\Resources\CompanySettingsResource;
use App\Models\CompanySetting;
use Illuminate\Http\Request;

class CompanySettingsAPIController extends Controller
{
    use HandlerResponse;

    public function index()
    {

        $settings = CompanySetting::all();
        return $this->responseCollection(data: new CompanySettingsCollection($settings));
    }
}
