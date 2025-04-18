<?php

namespace dashboard\controllers;
use dashboard\models\Appointments;
use dashboard\models\Patients;
use dashboard\models\MedicalRecords;
use dashboard\models\PharmacyInventory;
use dashboard\models\Tenancy; 
use Yii;
use yii\web\Response;
use dashboard\models\contactForm;


class SiteController extends \helpers\DashboardController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(),  [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'only' => ['index'],
                'formats' => [
                    'application/json' => Response::FORMAT_HTML,
                ],
            ],
        ]);
    }
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'layout' => 'errors'
            ],
        ];
    }
    public function actionIndex()
    {
        //Yii::$app->session->setFlash('success', 'Link created successfully');
        return $this->render('index');
    }
    public function actionDocs($mod = 'dashboard')
    {
        //$this->viewPath = '@swagger';
        return $this->render('docs', [
            'mod' => $mod
        ]);
    }
    public function actionAbout()
    {
        return [
            'data' => [
                'id' => $_SERVER['APP_CODE'],
                'name' => $_SERVER['APP_NAME'],
                'enviroment' => $_SERVER['ENVIRONMENT'],
                'version' => $_SERVER['APP_VERSION'],
            ]
        ];
    }

    public function actionJsonDocs($mod = 'dashboard')
    {
        $roothPath = Yii::getAlias('@webroot/');
        $openapi = \OpenApi\Generator::scan(
            [
                $roothPath . 'modules/' . $mod,
                $roothPath . 'providers/swagger/config',
            ]
        );
        Yii::$app->response->headers->set('Access-Control-Allow-Origin', ['*']);
        Yii::$app->response->headers->set('Content-Type', 'application/json');
        $file =  $roothPath . 'modules/dashboard/docs/' . $mod . '-openapi-json-resource.json';
        if (file_exists($file)) {
            unlink($file);
            file_put_contents($file, $openapi->toJson());
        } else {
            file_put_contents($file, $openapi->toJson());
        }
        Yii::$app->response->sendFile($file, false, ['mimeType' => 'json', 'inline' => true]);
        return true;
    }
    public function actionDashboard()
{
    return $this->render('dashboard');
}
public function actionExportCsv()
{
    $filename = 'tenancy_report.csv';
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=' . $filename);

    $fp = fopen('php://output', 'w');
    fputcsv($fp, ['Tenant', 'Unit', 'Start Date', 'End Date', 'Rent', 'Status']);

    $tenancies = Tenancy::find()->with(['tenant', 'unit'])->all();
    foreach ($tenancies as $tenancy) {
        fputcsv($fp, [
            $tenancy->tenant->username,
            $tenancy->unit->unit_number,
            $tenancy->start_date,
            $tenancy->end_date,
            $tenancy->unit->monthly_rent,
            $tenancy->payment_status == 1 ? 'Paid' : 'Unpaid'
        ]);
    }

    fclose($fp);
    Yii::$app->end();
}


//     public function actionDashboard()
// {
//     // Yii::$app->user->can('dashboard-dashboard');
//     $studentsCount = Students::find()->count();
//     $patientsCount = Patients::find()->count();
//     $appointmentsToday = Appointments::find()
//         ->where(['appointment_date' => date('Y-m-d')])
//         ->count();
//     $medicalRecords = MedicalRecords::find()->count();
//     $lowStockMeds = PharmacyInventory::find()->where(['<', 'quantity', 10])->count();

//     $appointmentChart = [
//         'labels' => json_encode(['Mon', 'Tue', 'Wed', 'Thu', 'Fri']),
//         'data' => json_encode([5, 10, 4, 8, 6])
//     ];

//     $genderData = json_encode([
//         Patients::find()->where(['gender' => 'Male'])->count(),
//         Patients::find()->where(['gender' => 'Female'])->count(),
//         Patients::find()->where(['gender' => 'Other'])->count()
//     ]);

//     return $this->render('dashboard', [
//         'studentsCount' => $studentsCount,
//         'patientsCount' => $patientsCount,
//         'appointmentsToday' => $appointmentsToday,
//         'medicalRecords' => $medicalRecords,
//         'lowStockMeds' => $lowStockMeds,
//         'appointmentChart' => $appointmentChart,
//         'genderData' => $genderData,
//     ]);
// }

    //  /**
    //  * Displays contact page.
    //  *
    //  * @return Response|string
    //  */
    // public function actionContact()
    // {
    //     $model = new ContactForm();
    //     if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
    //         Yii::$app->session->setFlash('contactFormSubmitted');

    //         return $this->refresh();
    //     }
    //     return $this->render('contact', [
    //         'model' => $model,
    //     ]);
    }

