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
        $credentials = base64_encode($this->consumerKey . ':' . $this->consumerSecret);

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $credentials
        ])->get($url);

        if ($response->successful()) {
            return $response->json()['access_token'];
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

        $data = [
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
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json'
        ])->post($url, $data);

        return $response->json();
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
