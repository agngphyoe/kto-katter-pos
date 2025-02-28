<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function exportType(string $list, Request $request)
    {
        $data = $request->input('data');
        return view('exports.choose-type', compact('list', 'request', 'data'));
    }
}
