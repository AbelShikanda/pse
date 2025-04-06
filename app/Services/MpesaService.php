<?php

namespace App\Services;

use App\Models\MpesaPayment;
use Carbon\Carbon;
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
        $this->consumerKey = config('mpesa.consumer_key');
        $this->consumerSecret = config('mpesa.consumer_secret');
        $this->shortcode = config('mpesa.shortcode');
        $this->passkey = config('mpesa.passkey');
        $this->callbackURL = config('mpesa.callback_url');
    }

    public function getAccessToken()
    {
        $url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
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

        $timestamp = Carbon::now()->format('YmdHis');
        $password = base64_encode($this->shortcode . $this->passkey . $timestamp);

        $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

        $stkpushheader = ['Content-Type:application/json', 'Authorization:Bearer ' . $accessToken];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $stkpushheader);
        $curl_post_data = array(
            'BusinessShortCode' => $this->shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerBuyGoodsOnline',
            'Amount' => $amount,
            'PartyA' => $phoneNumber,
            'PartyB' => '9030355',
            'PhoneNumber' => $phoneNumber,
            'CallBackURL' => $this->callbackURL,
            'AccountReference' => 'TestPayment',
            'TransactionDesc' => 'Payment for Order'
        );
        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);

        if (curl_errno($curl)) {
            return ['error' => 'CURL Error: ' . curl_error($curl)];
        }

        curl_close($curl);

        $responseData = json_decode($curl_response, true);

        if (!isset($responseData['ResponseCode'])) {
            return ['error' => 'Invalid response from M-Pesa', 'response' => $responseData];
        }

        if ($responseData['ResponseCode'] !== '0') {
            return ['error' => 'M-Pesa request failed', 'response' => $responseData];
        }

        return $responseData;
    }
}
