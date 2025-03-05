<?php

namespace App\Http\Controllers\API;

// use ReflectionClass;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Actions\HandlerResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;

class CategoryAPIController extends Controller
{
    use HandlerResponse;

    public function index()
    {
        $categories = Category::orderByDesc('id')->get();
        
        return $this->responseCollection(data: $categories);
    }
    
}