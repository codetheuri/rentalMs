<?php

namespace dashboard\controllers;

use helpers\DashboardController;
use Yii;

use dashboard\models\Payments;
use yii\web\NotFoundHttpException;


class BillingController extends DashboardController
{
    public function getViewPath()
    {
        return Yii::getAlias("@ui/views/ms/billing");
    } 
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionPayment()
    {
        // Yii::$app->user->can('dashboard-billing-payment');
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('payment');
        }
        return $this->render('index');
    }

    public function actionInitiatePayment()
    {
        
       
        if (Yii::$app->request->isPost) {
            $phoneNumber = Yii::$app->request->post('phone_number');
            $amount = Yii::$app->request->post('amount');

            try {
                $response = Yii::$app->mpesa->initiateSTKPush(
                    $phoneNumber,
                    $amount
                );
               
                return $this->asJson([
                    'success' => true,
                    'message' => 'Payment initiated successfully',
                    'data' => $response
                ],
            );
                
            } catch (\Exception $e) {
                Yii::error('Payment initiation failed: ' . $e->getMessage());
                return $this->asJson([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }
        }
    }

    // public function actionCallback()
    // {
    //     try {
    //         $rawInput = file_get_contents('php://input');
    //         Yii::info('Raw callback data received: ' . $rawInput, 'mpesa');
            
    //         $callbackData = json_decode($rawInput, true);
            
    //         if (json_last_error() !== JSON_ERROR_NONE) {
    //             Yii::error('JSON decode error: ' . json_last_error_msg(), 'mpesa');
    //             return $this->asJson(['success' => false, 'error' => 'Invalid JSON']);
    //         }
            
    //         if (!isset($callbackData['Body']['stkCallback'])) {
    //             Yii::error('Invalid callback structure - missing stkCallback', 'mpesa');
    //             return $this->asJson(['success' => false, 'error' => 'Invalid callback structure']);
    //         }

    //         $result = $callbackData['Body']['stkCallback'];
    //         Yii::info('Processing STK callback: ' . json_encode($result), 'mpesa');
            
    //         if ($result['ResultCode'] == 0) {
    //             $payment = new Payments();
    //             $metadata = [];
                
    //             if (isset($result['CallbackMetadata']['Item'])) {
    //                 foreach ($result['CallbackMetadata']['Item'] as $item) {
    //                     if (isset($item['Name'], $item['Value'])) {
    //                         $metadata[$item['Name']] = $item['Value'];
    //                     }
    //                 }
    //             }
                
    //             Yii::info('Extracted metadata: ' . json_encode($metadata), 'mpesa');
                
    //             if (isset($metadata['Amount'])) {
    //                 $payment->amount = $metadata['Amount'];
    //             } else {
    //                 Yii::error('Amount not found in callback metadata', 'mpesa');
    //                 return $this->asJson(['success' => false, 'error' => 'Amount not found']);
    //             }
                
    //             $payment->transaction_id = $result['CheckoutRequestID'];
    //             // $payment->status = 'completed';
                
    //             Yii::info('Attempting to save payment: ' . json_encode([
    //                 'amount' => $payment->amount,
    //                 'transaction_id' => $payment->transaction_id,
    //                 // 'status' => $payment->status
    //             ]), 'mpesa');
                
    //             if (!$payment->save()) {
    //                 Yii::error('Payment save error: ' . json_encode($payment->errors), 'mpesa');
    //                 return $this->asJson(['success' => false, 'error' => 'Failed to save payment']);
    //             }
                
    //             Yii::info('Payment saved successfully: ' . $payment->transaction_id, 'mpesa');
    //             return $this->asJson(['success' => true]);
    //         }
            
    //         Yii::error('Payment failed with ResultCode: ' . $result['ResultCode'], 'mpesa');
    //         return $this->asJson(['success' => false, 'error' => 'Payment failed']);
            
    //     } catch (\Exception $e) {
    //         Yii::error('Callback processing error: ' . $e->getMessage() . "\nStack trace: " . $e->getTraceAsString(), 'mpesa');
    //         return $this->asJson(['success' => false, 'error' => $e->getMessage()]);
    //     }
    // }
    public function actionCallback()
    {
        $rawInput = file_get_contents('php://input');
        $result = $this->callbackProcessor->processCallback($rawInput);
        return $this->asJson($result);
    }
}