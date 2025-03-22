<?php

namespace App\Services;

use App\Models\MpesaPayment;
use Illuminate\Support\Facades\Http;

class MpesaService
{
    private $consumerKey;
    private $consumerSecret;
    private $shortcode;
    private $passkey;
    private $callbackURL;

    public function __construct()
    {
        $this->consumerKey = env('MPESA_CONSUMER_KEY');
        $this->consumerSecret = env('MPESA_CONSUMER_SECRET');
        $this->shortcode = env('MPESA_SHORTCODE');
        $this->passkey = env('MPESA_PASSKEY');
        $this->callbackURL = env('MPESA_CALLBACK_URL');
    }

    public function getAccessToken()
    {
        $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        $headers = ['Content-Type:application/json; charset=utf8'];
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_HEADER, FALSE);
        curl_setopt($curl, CURLOPT_USERPWD, $this->consumerKey . ':' . $this->consumerSecret);

        $response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($status !== 200) {
            return null;
        }

        $result = json_decode($response);

        if (isset($result->access_token)) {
            return $result->access_token;
        }

        return null;
    }

    public function stkPushRequest($phoneNumber, $amount)
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            return ['error' => 'Failed to generate access token'];
        }

        $timestamp = now()->format('YmdHis');
        $password = base64_encode($this->shortcode . $this->passkey . $timestamp);

        $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

        $stkpushheader = ['Content-Type:application/json', 'Authorization:Bearer ' . $accessToken];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $stkpushheader);
        $curl_post_data = array(
            'BusinessShortCode' => $this->shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $amount,
            'PartyA' => $phoneNumber,
            'PartyB' => $this->shortcode,
            'PhoneNumber' => $phoneNumber,
            'CallBackURL' => $this->callbackURL,
            'AccountReference' => 'TestPayment',
            'TransactionDesc' => 'Payment for Order'
        );
        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        echo $curl_response = curl_exec($curl);

        $data = json_decode($curl_response);

        $CheckoutRequestID = $data->CheckoutRequestID;
        $ResponseCode = $data->ResponseCode;
        if ($ResponseCode == '0') {
            echo 'The CheckoutRequestID for this transaction is : ' . $CheckoutRequestID;
        }
    }

    public function handleMpesaCallback($mpesaResponse)
    {
        if (isset($mpesaResponse['Body']['stkCallback'])) {
            $callback = $mpesaResponse['Body']['stkCallback'];

            if ($callback['ResultCode'] == 0) {
                $metadata = collect($callback['CallbackMetadata']['Item']);

                $amount = $metadata->where('Name', 'Amount')->first()['Value'] ?? null;
                $receipt = $metadata->where('Name', 'MpesaReceiptNumber')->first()['Value'] ?? null;
                $phoneNumber = $metadata->where('Name', 'PhoneNumber')->first()['Value'] ?? null;

                // Store payment in database
                return MpesaPayment::create([
                    'phone_number' => $phoneNumber,
                    'amount' => $amount,
                    'receipt_number' => $receipt,
                    'status' => 'Completed'
                ]);
            }
        }

        return null;
    }
}
