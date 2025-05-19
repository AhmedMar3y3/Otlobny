<?php

namespace App\Services\PaymentGateway;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Exception\GuzzleException;

class MyFatoorahService 
{
    protected $API_TOKEN;
    protected $NAME;
    protected $MODE;
    protected $base_url;

    public function __construct()
    {
        $this->NAME       = 'Myfatoorah';
        $this->MODE       = config('payments.' . $this->NAME . '.MODE');
        $this->API_TOKEN  = config('payments.' . $this->NAME . '.'.$this->MODE.'_API_TOKEN');
        $this->base_url   = config('payments.' . $this->NAME . '.'.$this->MODE.'_BASE_URL');
    }

    public function createPayment($request , $user)
    {
        $data = self::getPaymentTransactionInfo( $request['amount'], $user);
        try { 
            $payemtResponse = Http::withHeaders(
                ['Content-Type' => 'application/json','authorization' => 'Bearer ' . $this->API_TOKEN],
            )->post($this->base_url . '/v2/SendPayment', $data);

            return [
                'payment_name'     => $this->NAME, 
                'paymentResponse'   => $payemtResponse,
                'transaction_id'   => json_decode($payemtResponse,true)['Data']['InvoiceId'],
                'redirect_url'     => json_decode($payemtResponse,true)['Data']['InvoiceURL'],
            ];
        } catch (GuzzleException $exception) {
            return ['key' => 'fail' , 'msg' => $exception->getMessage()];
        }
    }

    public function getPaymentTransactionInfo($amount , $user): array
    {
        return [
            'CustomerName'       =>  $user->first_name . ' ' . $user->last_name,
            'NotificationOption' =>  'Lnk',
            'InvoiceValue'       =>  $amount ,
            'MobileCountryCode'  =>  '+' .$user->country_code,
            'CustomerMobile'     =>  $user->phone,
            'CustomerEmail'      =>  $user->email,
            'Language'           =>  'ar',
            'DisplayCurrencyIso' =>  'SAR' ,
            'CallBackUrl'        =>  route('payment.getPaymentStatus'),
            'ErrorUrl'           =>  route('payment.getPaymentStatus'),
            'CustomerReference'  =>  1,
            'UserDefinedField'   =>  'user'
        ];
    }

    public function getPaymentStatus($transactionId)
    {
        try {
            $postfields = [
                'Key' => $transactionId,
                'KeyType' => 'paymentId'
            ];
            
            $response = Http::withHeaders(
                ['Content-Type' => 'application/json','authorization' => 'Bearer ' . $this->API_TOKEN],
            )->post($this->base_url . '/v2/getPaymentStatus', $postfields);
            
            return [
                'status'         => json_decode($response,true)['Data']['InvoiceTransactions'][0]['TransactionStatus'] == 'Failed' ? 0 : 1 ,
                'transaction_id' => json_decode($response,true)['Data']['InvoiceId'] ,
            ];
        } catch (GuzzleException $exception) {
            return ['key' => 'fail' , 'msg' => $exception->getMessage()];
        }
    }
}
