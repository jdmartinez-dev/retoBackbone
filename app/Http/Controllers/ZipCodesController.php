<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ZipCodesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($zip_code = '')
    {   
        $query = \App\Models\Zipcode::where('zip_code', $zip_code)->firstOrFail();
        
        return response()->json($query);
    }
}
