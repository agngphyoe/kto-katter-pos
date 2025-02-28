<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExcelImport\FileImportRequest;
use App\Imports\CustomerImport;
use App\Imports\ProductImport;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class ExcelImportController extends Controller
{
    public function customerFileImport()
    {
        return view('import.customer');
    }

    public function importCustomers(Request $request)
    {
        $rules = [
            'file' => ['required', 'file', 'mimes:xlsx,xls', 'max:2048'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->with('error', 'Something went wrong !');
        }

        try {

            $import = new CustomerImport();

            Excel::import($import, $request->file);

            if ($import->getSuccess()) {

                return redirect()->route('customer')->with('success', 'Customers imported successfully!');
            }
        } catch (ValidationException $e) {

            return redirect()->back()->with(['error' => $e->errors()['code'][0]]);
        } catch (\Exception $e) {

            return redirect()->back()->with(['error' => 'An error occurred during import. Please try again.']);
        }
    }

    public function productFileImport()
    {

        return view('import.product');
    }

    public function importProducts(Request $request)
    {
        $rules = [
            'file' => ['required', 'file', 'mimes:xlsx,xls', 'max:2048'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->with('error', 'Something went wrong !');
        }

        try {
            $import = new ProductImport();

            Excel::import($import, $request->file);

            if ($import->getSuccess()) {

                return redirect()->route('product')->with('success', 'Products imported successfully!');
            }
        } catch (ValidationException $e) {

            return redirect()->back()->with(['error' => $e->errors()['code'][0]]);
        } catch (\Exception $e) {

            return redirect()->back()->with(['error' => 'An error occurred during import. Please try again.']);
        }
    }
}
