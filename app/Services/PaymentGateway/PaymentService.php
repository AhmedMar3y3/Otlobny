<?php

namespace App\Services\PaymentGateway;

use Illuminate\Http\Request;
use App\Enums\PaymentTransactions;
use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\DB;
use App\Services\Order\ConfirmPaymentOrderService;

class PaymentService
{
    public static function create()
    {
        return new MyFatoorahService;
    }

    public function createPaymentTransaction($amount, $type, $transactionable_type, $transactionable_id, $transaction_id, $payemtResponse, $paymentName, $user = null, $promotion_id = null)
    {

        PaymentTransaction::create([
            'payment_getaway'  => $paymentName,
            'transaction_id'   => $transaction_id,
            'type'             => $type,
            'amount'           => $amount,
            'currency_code'    => 'EGP',
            'status'           => 'pending',
            'getaway_response' => $payemtResponse,
            'trans_type'       => $transactionable_type,
            'trans_id'         => $transactionable_id,
            'user_type'        => $user ? get_class($user) : null,
            'user_id'          => $user ? $user->id : null,
        ]);
    }

    public static function callback(Request $request)
    {
        $serviceClass = new MyFatoorahService();
        $data = $serviceClass->getPaymentStatus($request->paymentId);
        return PaymentService::checkPayment($data);
    }
    public static function checkPayment($data)
    {
        $transaction = PaymentTransaction::with('user', 'trans')->where(
            'transaction_id', $data['transaction_id']
        )->firstOrFail();

        if (!$data['status']) {
            $transaction->update([
                'status' => 'failed'
            ]);
			return redirect()->route('payment.failed', [
				'transaction_id' => $data['transaction_id'],
				'status'         => $data['status']
			]);
        }

        DB::beginTransaction();
        try
        {
            $transaction->update([
                'status' => 'completed'
            ]);
            if ($transaction->type == PaymentTransactions::PAY_ORDER->value) {
                (new ConfirmPaymentOrderService())->confirmPayment($transaction->trans);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return redirect()->route('payment.success', [
			'transaction_id' => $data['transaction_id'],
			'status'         => $data['status']
		]);
    }

	public function success(Request $request)
	{
		return view('Admin.payment.success', [
			'trans_id' => $request->transaction_id,
		]);
	}
	public function failed(Request $request)
	{
		return view('Admin.payment.failed', [
			'trans_id' => $request->transaction_id,
		]);
	}
}
