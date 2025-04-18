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
        $this->consumerKey = 'rrZVs6pU7AHQHq6xRzFUXGLlf9hzNKsnTRnSSBfGz6889ZES';
        $this->consumerSecret = '9SFHqGDvE0wtZJzeMK9VCDHZaU7OSlMB3sGerMR2kiBgEIjgG1lAncIukpBipk9L';
        $this->passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
        $this->shortcode = '174379';
        $this->env =  'sandbox';
        
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

    public function initiateSTKPush($phoneNumber, $amount)
    {
        try {
            $accessToken = $this->getAccessToken();
            $timestamp = date('YmdHis');
            $password = base64_encode($this->shortcode . $this->passkey . $timestamp);
            
            $url = $this->getApiUrl('mpesa/stkpush/v1/processrequest');
            $callbackUrl = "https://2290-197-231-178-131.ngrok-free.app/api/mpesa/callback/";

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
                'AccountReference' => 'RentalMS',
                'TransactionDesc' => 'Payment for rent',
            ];

            Yii::info('STK Push request payload: ' . json_encode($data), 'mpesa');

            $response = $this->makeRequest($url, [
                'headers' => [
                    'Authorization: Bearer ' . $accessToken,
                    'Content-Type: application/json'
                ],
                'method' => 'POST',
                'data' => $data
            ]);
            
            Yii::info('STK Push response: ' . json_encode($response), 'mpesa');
            return $response;
            
        } catch (\Exception $e) {
            Yii::error('M-Pesa API error: ' . $e->getMessage());
            throw $e;
        }
    }

    private function getApiUrl($endpoint)
    {
        $baseUrl = $this->env === 'sandbox' 
            ? 'https://sandbox.safaricom.co.ke/'
            : 'https://api.safaricom.co.ke/';
        return $baseUrl . $endpoint;
    }

    private function makeRequest($url, $options)
    {
        $ch = curl_init($url);
        
        if (isset($options['headers'])) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $options['headers']);
        }
        
        if ($options['method'] === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            if (isset($options['data'])) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($options['data']));
            }
        }
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new \Exception('Failed to connect to M-Pesa API: ' . $error);
        }
        
        curl_close($ch);
        
        $decoded = json_decode($response);
        if (!$decoded) {
            throw new \Exception('Invalid response from M-Pesa API');
        }
        
        return $decoded;
    }
}