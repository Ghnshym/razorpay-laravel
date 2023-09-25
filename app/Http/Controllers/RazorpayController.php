<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Payment;
use Illuminate\Support\Facades\Session;

class RazorpayController extends Controller
{

    public function index(){
        return view('payment');
    }


    public function store(Request $request) {
        $input = $request->all();
        $api = new Api (env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
        if(count($input) && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount' => $payment['amount']));
                $payment = Payment::create([
                    'r_payment_id' => $response['id'],
                    'method' => $response['method'],
                    'currency' => $response['currency'],
                    'user_email' => $response['email'],
                    'amount' => $response['amount']/100,
                    'json_response' => json_encode((array)$response)
                ]);

                return redirect()->route('fetch-transaction', ['payment_id' => $response['id']]);

            } catch(Exceptio $e) {
                return $e->getMessage();
                Session::put('error',$e->getMessage());
                return redirect()->back();
            }
        }
        Session::put('success', 'Payment Successful');
        return redirect()->back();
    }


    public function fetchTransaction($payment_id) {
        try {
            // Fetch the payment record from your database based on the payment ID.
            $paymentRecord = Payment::where('r_payment_id', $payment_id)->first();
    
            if (!$paymentRecord) {
                return response()->json(['error' => 'Payment record not found'], 404);
            }
    
            // Pass the payment record to the 'result' view and display it in the card.
            return view('result', ['paymentRecord' => $paymentRecord]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
