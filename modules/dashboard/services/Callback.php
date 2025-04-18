<?php

namespace dashboard\services;

use Yii;
use dashboard\models\Payments;

class MpesaCallbackProcessor
{
    public function processCallback($rawInput)
    {
        try {
            Yii::info('Raw callback data: ' . $rawInput, 'mpesa');
            
            $callbackData = json_decode($rawInput, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                Yii::error('JSON decode error: ' . json_last_error_msg(), 'mpesa');
                return ['success' => false, 'error' => 'Invalid JSON'];
            }
            
            if (!isset($callbackData['Body']['stkCallback'])) {
                Yii::error('Invalid callback structure', 'mpesa');
                return ['success' => false, 'error' => 'Invalid callback structure'];
            }

            return $this->handleSTKCallback($callbackData['Body']['stkCallback']);
            
        } catch (\Exception $e) {
            Yii::error('Callback processing error: ' . $e->getMessage(), 'mpesa');
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    private function handleSTKCallback($result)
    {
        if ($result['ResultCode'] != 0) {
            Yii::error('Payment failed with ResultCode: ' . $result['ResultCode'], 'mpesa');
            return ['success' => false, 'error' => 'Payment failed'];
        }

        try {
            $payment = $this->createPaymentFromCallback($result);
            
            if (!$payment->save()) {
                Yii::error('Payment save error: ' . json_encode($payment->errors), 'mpesa');
                return ['success' => false, 'error' => 'Failed to save payment'];
            }
            
            Yii::info('Payment saved successfully: ' . $payment->transaction_id, 'mpesa');
            return ['success' => true];
            
        } catch (\Exception $e) {
            Yii::error('Payment creation error: ' . $e->getMessage(), 'mpesa');
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    private function createPaymentFromCallback($result)
    {
        $payment = new Payments();
        $payment->transaction_id = $result['CheckoutRequestID'];
        
        if (isset($result['CallbackMetadata']['Item'])) {
            foreach ($result['CallbackMetadata']['Item'] as $item) {
                if ($item['Name'] === 'Amount' && isset($item['Value'])) {
                    $payment->amount = $item['Value'];
                }
            }
        }
        
        return $payment;
    }
}