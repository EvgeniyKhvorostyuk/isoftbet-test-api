<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

use \Carbon\Carbon;

class CustomerController extends Controller
{
    /**
     * Stores a new customer
     */
    public function store(Request $request)
    {
        $required_params = ['name'];

        $has_errors = checkQueryParams($request, $required_params);

        if ($has_errors) {
            return response()->json(responseParams(422, $has_errors), 422);
        }

        if (empty($request->name)) {
            return response()->json(responseParams(422, ['name']), 422);
        }

        try {
            $customer = new Customer;
            $customer->name = $request->name;
            $customer->cnp = isset($request->cnp) && !empty($request->cnp) ? (boolean) $request->cnp : false;
            $customer->save();
        } catch (\Exception $exception) {
            return response()->json(responseParams(500), 500);
        }

        $response_params = [
            'customerId' => $customer->id
        ];

        return response()->json($response_params, 200);
    }

    /**
     * Gets customer's tranasction
     */
    public function transaction($customer_id, $transaction_id)
    {
        $customer = Customer::where('id', $customer_id)->first();

        if (is_null($customer)) {
            return response(responseParams(404, 'Customer not found'), 404);
        }
        
        $transaction = $customer->transactions()->where('id', $transaction_id)->first();
        
        if (is_null($transaction)) {
            return response(responseParams(404, 'Transaction not found'), 404);
        }

        $response_params = [
            'transactionId' => $transaction->id,
            'amount' => $transaction->amount,
            'date' => Carbon::parse($transaction->updated_at)->format('m-d-Y')
        ];

        return response()->json($response_params, 200);
    }
}
