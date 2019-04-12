<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Transaction;
use Illuminate\Http\Request;

use DB;
use \Carbon\Carbon;

class TransactionController extends Controller
{
    /**
     * Gets transactions (by filter)
     */
    public function index(Request $request)
    {
        $allowed_filters = ['customerId', 'amount', 'date', 'offset', 'limit'];

        $query = DB::table('transactions');

        foreach ($request->all() as $query_param_name => $value) {
            if (in_array($query_param_name, $allowed_filters)) {
                switch ($query_param_name) {
                    case 'customerId':
                        $query = $query->where('customer_id', $value);
                        break;
                    case 'amount':
                        $query = $query->where('amount', number_format((float) $value, 2, '.', ''));
                        break;
                    case 'date':
                        $query = $query->whereDate('updated_at', Carbon::parse($value)->toDateString());
                        break;
                    case 'offset':
                        $query = $query->offset(intval($value));
                        break;
                    case 'limit':
                        $query = $query->limit(intval($value));
                        break;
                }
            }
        }

        $transactions = $query->get();
        
        if ($transactions->isEmpty()) {
            return response()->json(responseParams(404, 'Transactions not found'), 404);
        }

        $response_params = [];
        
        foreach ($transactions as $transaction) {
            $response_params[] = [
                'transactionId' => $transaction->id,
                'customerId' => $transaction->customer_id,
                'amount' => $transaction->amount,
                'date' => Carbon::parse($transaction->updated_at)->format('m-d-Y')
            ];
        }
        
        return response()->json($response_params, 200);
    }

    /**
     * Stores a new transaction
     */
    public function store(Request $request)
    {
        $required_params = ['customerId', 'amount'];

        $has_errors = checkQueryParams($request, $required_params);

        if ($has_errors) {
            return response()->json(responseParams(422, $has_errors), 422);
        }

        $customer = Customer::where('id', $request->customerId)->first();

        if (is_null($customer)) {
            return response()->json(responseParams(404, 'Customer not found'), 404);
        }

        try {
            $transaction = new Transaction;
            $transaction->customer_id = $customer->id;
            $transaction->amount = number_format((float) $request->amount, 2, '.', '');
            $transaction->save();
        } catch (\Exception $exception) {
            return response()->json(responseParams(500), 500);
        }

        $response_params = [
            'transactionId' => $transaction->id,
            'customerId' => $transaction->customer_id,
            'amount' => $transaction->amount,
            'date' => Carbon::parse($transaction->updated_at)->format('m-d-Y')
        ];

        return response()->json($response_params, 200);
    }

    /**
     * Updates transaction
     */
    public function update(Request $request, $id)
    {
        $transaction = Transaction::where('id', $id)->first();
        
        if (is_null($transaction)) {
            return response()->json(responseParams(404, 'Transaction not found'), 404);
        }

        $has_errors = checkQueryParams($request, ['amount']);

        if ($has_errors) {
            return response()->json(responseParams(422, $has_errors), 422);
        }

        try {
            $transaction->amount = number_format((float) $request->amount, 2, '.', '');
            $transaction->save();
        } catch (\Exception $exception) {
            return response()->json(responseParams(500), 500);
        }

        $response_params = [
            'transactionId' => $transaction->id,
            'customerId' => $transaction->customer_id,
            'amount' => $transaction->amount,
            'date' => Carbon::parse($transaction->updated_at)->format('m-d-Y')
        ];

        return response()->json($response_params, 200);
    }

    /**
     * Deletes transaction
     */
    public function destroy(Request $request, $id)
    {
        $transaction = Transaction::where('id', $id)->first();

        if (is_null($transaction)) {
            return response()->json(responseParams(404, 'Transaction not found'), 404);
        }

        $transaction->delete();

        return response()->json(responseParams(200), 200);
    }
}
