<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function getallcustomers()
    {
        $customers = Customer::orderBy('firstname', 'DESC')->get();

        return response()->json([
            'customers' => $customers,
        ], 200);
    }
}
