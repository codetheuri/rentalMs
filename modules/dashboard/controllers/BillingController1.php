<?php

namespace dashboard\controllers;

use Yii;

use dashboard\models\Payments;
use helpers\DashboardController;

class BillingController1 extends DashboardController
{
    public function getViewPath()
    {
        return Yii::getAlias("@ui/views/hms/billing");
    } 
    public function actionIndex()
    {
        
        return $this->render('index');
    }
    public function actionPayment()
    {
        if($this->request->isAjax) {
            return $this->renderAjax('payment');
        }
        else{
            return $this->render('index');
        }
        
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
                    Yii::$app->session->setFlash('success', 'Payment initiated successfully'),
                   
                    'data' => $response
                ]);
                
            } catch (\Exception $e) {
                Yii::error('Payment initiation failed: ' . $e->getMessage());
                return $this->asJson([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }
        }
    }

//     public function actionCallback()
//     {
//         $callbackData = json_decode(file_get_contents('php://input'), true);
        
//         Yii::info('M-Pesa Callback received: ' . json_encode($callbackData));

//         if (isset($callbackData['Body']['stkCallback'])) {
//             $result = $callbackData['Body']['stkCallback'];
            
//             if ($result['ResultCode'] == 0) {
//                 $payment = new Payments();
//                 $payment->amount = $result['Amount'];
//                 $payment->transaction_id = $result['CheckoutRequestID'];
           
//                 $payment->save();
//             }
//         }

//         return $this->asJson(['success' => true]);
//     }
// }

public function actionCallback()
    {
        try {
            $rawInput = file_get_contents('php://input');
            Yii::info('Raw callback data: ' . $rawInput, 'mpesa');
            
            $callbackData = json_decode($rawInput, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                Yii::error('JSON decode error: ' . json_last_error_msg(), 'mpesa');
                return $this->asJson(['success' => false, 'error' => 'Invalid JSON']);
            }
            
            Yii::info('M-Pesa Callback received: ' . json_encode($callbackData), 'mpesa');

            if (isset($callbackData['Body']['stkCallback'])) {
                $result = $callbackData['Body']['stkCallback'];
                
                if ($result['ResultCode'] == 0) {
                    // Extract payment details from the callback
                    $payment = new Payments();
                    
                    // Loop through the CallbackMetadata Items to find Amount and TransactionId
                    foreach ($result['CallbackMetadata']['Item'] as $item) {
                        if ($item['Name'] === 'Amount') {
                            $payment->amount = $item['Value'];
                        }
                    }
                    
                    $payment->transaction_id = $result['CheckoutRequestID'];
                    // $payment->status = 'completed';
                    
                    if (!$payment->save()) {
                        Yii::error('Payment save error: ' . json_encode($payment->errors), 'mpesa');
                        return $this->asJson(['success' => false, 'error' => 'Failed to save payment']);
                    }
                    
                    Yii::info('Payment saved successfully: ' . $payment->transaction_id, 'mpesa');
                } else {
                    Yii::error('Payment failed with ResultCode: ' . $result['ResultCode'], 'mpesa');
                }
            } else {
                Yii::error('Invalid callback structure', 'mpesa');
                return $this->asJson(['success' => false, 'error' => 'Invalid callback structure']);
            }

            return $this->asJson(['success' => true]);
            
        } catch (\Exception $e) {
            Yii::error('Callback error: ' . $e->getMessage(), 'mpesa');
            return $this->asJson(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
