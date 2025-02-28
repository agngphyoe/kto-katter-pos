<?php

namespace App\Http\Controllers;

use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Http\Requests\ProductPrefix\StoreRequest;
use App\Http\Requests\ProductPrefix\UpdateRequest;
use App\Models\ProductPrefix;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ProductPrefixController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $total_count    = ProductPrefix::count();

        $product_prefixs          = ProductPrefix::orderByDesc('id')->paginate(10);

        return view('product-prefix.index', compact('product_prefixs', 'total_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (ProductPrefix::exists()) {

            return redirect()->route('product-prefix')->with('error', 'Prefix is already created.');
        }

        return view('product-prefix.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $prefix = ProductPrefix::create($request->all());

        if ($prefix) {

            return redirect()->route('product-prefix')->with('success', 'Success! Product Prefix Created');
        }

        return back()->with('error', 'Failed! Product Prefix can\'t Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductPrefix  $productPrefix
     * @return \Illuminate\Http\Response
     */
    public function show(ProductPrefix $prefix)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductPrefix  $productPrefix
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductPrefix $prefix)
    {
        return view('product-prefix.edit', compact('prefix'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductPrefix  $productPrefix
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, ProductPrefix $prefix)
    {
        $prefix->update($request->all());

        if ($prefix) {

            return redirect('product-prefix')->with('success', 'Success! Product Prefix Updated');
        }

        return back()->with('error', 'Failed! Product Prefix not updated');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductPrefix  $productPrefix
     * @return \Illuminate\Http\Response
     */

    public function changeStatus(Request $request, ProductPrefix $prefix)
    {
        try {
            $prefix->status = $request->status;
    
            if ($request->status === 'enable') {
                $prefix->prefix_type = null;
            } elseif ($request->status === 'disable' && $request->filled('prefix_type')) {
                $prefix->prefix_type = $request->prefix_type;
            }
    
            $prefix->save();
    
            return response()->json([
                'message' => $prefix->status === 'enable' ? 'Standard Prefix is Enabled' : 'Auto Prefix is Enabled',
                'status' => $prefix->status,
                'prefix_type' => $prefix->prefix_type ?? '-'
            ]);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error updating status'], 500);
        }
    }    
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductPrefix  $productPrefix
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductPrefix $prefix)
    {
        //
    }


}
