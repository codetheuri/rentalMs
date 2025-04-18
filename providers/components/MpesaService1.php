<?php

namespace app\providers\components;

use Yii;
use yii\base\Component;

class MpesaService extends Component
{
    private $consumerKey;
    private $consumerSecret;
    private $passkey;
    private $shortcode;
    private $env;
    
    public function init()
    {
        parent::init();
        // Initialize with your Daraja API credentials
        $this->consumerKey ='rrZVs6pU7AHQHq6xRzFUXGLlf9hzNKsnTRnSSBfGz6889ZES';
        $this->consumerSecret = '9SFHqGDvE0wtZJzeMK9VCDHZaU7OSlMB3sGerMR2kiBgEIjgG1lAncIukpBipk9L';
        $this->passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
        $this->shortcode = '174379';
        $this->env = 'sandbox'; // or 'production'
        
        // Validate required credentials
        if (!$this->consumerKey || !$this->consumerSecret) {
            throw new \Exception('M-Pesa API credentials are not configured');
        }
    }

    private function getAccessToken()
    {
        $url = $this->env === 'sandbox' 
            ? 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials'
            : 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $credentials = base64_encode($this->consumerKey . ':' . $this->consumerSecret);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Basic ' . $credentials]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            Yii::error('Curl error: ' . curl_error($ch));
            throw new \Exception('Failed to connect to M-Pesa API');
        }
        
        curl_close($ch);
        
        $result = json_decode($response);
        
        if (!$result || !isset($result->access_token)) {
            Yii::error('Invalid response from M-Pesa API: ' . $response);
            throw new \Exception('Failed to get access token from M-Pesa API');
        }
        
        return $result->access_token;
    }

    // public function initiateSTKPush($phoneNumber, $amount)
    // {
    //     try {
    //         $accessToken = $this->getAccessToken();
            
    //         $timestamp = date('YmdHis');
    //         $password = base64_encode($this->shortcode . $this->passkey . $timestamp);
            
    //         $url = $this->env === 'sandbox'
    //             ? 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest'
    //             : 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

    //         $data = [
    //             'BusinessShortCode' => $this->shortcode,
    //             'Password' => $password,
    //             'Timestamp' => $timestamp,
    //             'TransactionType' => 'CustomerPayBillOnline',
    //             'Amount' => $amount,
    //             'PartyA' => $phoneNumber,
    //             'PartyB' => $this->shortcode,
    //             'PhoneNumber' => $phoneNumber,
    //             'CallBackURL' => "https://e531-197-231-178-131.ngrok-free.app/",
    //             'AccountReference' => 'Oljabet Hospital',
    //             'TransactionDesc' => 'Payment for medical services'
    //         ];

    //         $ch = curl_init($url);
    //         curl_setopt($ch, CURLOPT_HTTPHEADER, [
    //             'Authorization: Bearer ' . $accessToken,
    //             'Content-Type: application/json'
    //         ]);
    //         curl_setopt($ch, CURLOPT_POST, true);
    //         curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            
    //         $response = curl_exec($ch);
            
    //         if (curl_errno($ch)) {
    //             Yii::error('Curl error: ' . curl_error($ch));
    //             throw new \Exception('Failed to connect to M-Pesa API');
    //         }
            
    //         curl_close($ch);
            
    //         $result = json_decode($response);
            
    //         if (!$result) {
    //             Yii::error('Invalid response from M-Pesa API: ' . $response);
    //             throw new \Exception('Invalid response from M-Pesa API');
    //         }
            
    //         return $result;
            
    //     } catch (\Exception $e) {
    //         Yii::error('M-Pesa API error: ' . $e->getMessage());
    //         throw $e;
    //     }
    
    public function initiateSTKPush($phoneNumber, $amount)
    {
        try {
            $accessToken = $this->getAccessToken();
            
            $timestamp = date('YmdHis');
            $password = base64_encode($this->shortcode . $this->passkey . $timestamp);
            
            $url = $this->env === 'sandbox'
                ? 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest'
                : 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

            // Log the callback URL we're about to use
            $callbackUrl = "https://ea59-41-89-128-5.ngrok-free.app/api/mpesa/callback";
            Yii::info('Setting callback URL to: ' . $callbackUrl, 'mpesa');

            $data = [
                'BusinessShortCode' => $this->shortcode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'TransactionType' => 'CustomerPayBillOnline',
                'Amount' => $amount,
                'PartyA' => $phoneNumber,
                'PartyB' => $this->shortcode,
                'PhoneNumber' => $phoneNumber,
                'CallBackURL' => $callbackUrl,
                'AccountReference' => 'Tum wellness centre',
                'TransactionDesc' => 'Payment for medical services'
            ];

            // Log the request payload
            Yii::info('STK Push request payload: ' . json_encode($data), 'mpesa');

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $accessToken,
                'Content-Type: application/json'
            ]);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            
            $response = curl_exec($ch);
            
            // Log the raw response
            Yii::info('STK Push raw response: ' . $response, 'mpesa');
            
            if (curl_errno($ch)) {
                Yii::error('Curl error: ' . curl_error($ch));
                throw new \Exception('Failed to connect to M-Pesa API');
            }
            
            curl_close($ch);
            
            $result = json_decode($response);
            
            if (!$result) {
                Yii::error('Invalid response from M-Pesa API: ' . $response);
                throw new \Exception('Invalid response from M-Pesa API');
            }
            
            // Log the decoded response
            Yii::info('STK Push decoded response: ' . json_encode($result), 'mpesa');
            
            return $result;
            
        } catch (\Exception $e) {
            Yii::error('M-Pesa API error: ' . $e->getMessage());
            throw $e;
        }
    }
}