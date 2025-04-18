<?php

namespace dashboard\controllers;

use Yii;
use dashboard\models\Tenancy;
use dashboard\models\searches\TenancySearch;
use helpers\DashboardController;
use yii\web\NotFoundHttpException;

/**
 * TenancyController implements the CRUD actions for Tenancy model.
 */
class TenancyController extends DashboardController
{
    public $permissions = [
        'dashboard-tenancy-list' => 'View Tenancy List',
        'dashboard-tenancy-create' => 'Add Tenancy',
        'dashboard-tenancy-update' => 'Edit Tenancy',
        'dashboard-tenancy-delete' => 'Delete Tenancy',
        'dashboard-tenancy-restore' => 'Restore Tenancy',
    ];
    public function getViewPath()
    {
        return Yii::getAlias("@ui/views/ms/tenancy");
    }
    public function actionIndex()
    {
        Yii::$app->user->can('dashboard-tenancy-list');
        $searchModel = new TenancySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCreate()
    {
        Yii::$app->user->can('dashboard-tenancy-create');
        $model = new Tenancy();
        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Tenancy created successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->loadDefaultValues();
        }
        if ($this->request->isAjax) {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    public function actionUpdate($id)
    {
        Yii::$app->user->can('dashboard-tenancy-update');
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Tenancy updated successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        }
        if ($this->request->isAjax) {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    public function actionTrash($id)
    {
        $model = $this->findModel($id);
        if ($model->is_deleted) {
            Yii::$app->user->can('dashboard-tenancy-restore');
            $model->restore();
            Yii::$app->session->setFlash('success', 'Tenancy has been restored');
        } else {
            Yii::$app->user->can('dashboard-tenancy-delete');
            $model->delete();
            Yii::$app->session->setFlash('success', 'Tenancy has been deleted');
        }
        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = Tenancy::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionReceipt($id)
    {
        $model = $this->findModel($id); // Find tenancy by ID

        return $this->render('receipt', [
            'model' => $model,
        ]);
    }
    public function actionReceipts()
    {
        $tenancies = \dashboard\models\Tenancy::find()->where(['payment_status' => 1])->all(); // Get all tenancies with payment status 1 (paid)
        if (empty($tenancies)) {
            Yii::$app->session->setFlash('info', 'No receipts available for paid tenancies.');
            return $this->redirect(['index']);
        }

        return $this->render('receipts', [
            'tenancies' => $tenancies,
        ]);
    }
    public function actionSummary()
{
    
    $tenancies = \dashboard\models\Tenancy::find()->all();
    $totalExpected = 0;
    $totalPaid = 0;
    $arrearsList = [];

    foreach ($tenancies as $tenancy) {
        $unit = \dashboard\models\Unit::findOne($tenancy->unit_id);
        $monthlyRent = $unit->monthly_rent ?? 0;
        $totalExpected += $monthlyRent;

        if ($tenancy->payment_status === 1) {
            $totalPaid += $monthlyRent;
        } else {
            $arrearsList[] = [
                'tenant' => \Auth\models\User::findOne($tenancy->tenant_id)->username ?? 'Unknown',
                'unit' => $unit->unit_number ?? 'N/A',
                'property' => $unit->property->name ?? 'N/A',
                'amount_due' => $monthlyRent,
            ];
        }
    }

    $totalArrears = $totalExpected - $totalPaid;

    return $this->render('summary', [
        'totalExpected' => $totalExpected,
        'totalPaid' => $totalPaid,
        'totalArrears' => $totalArrears,
        'arrearsList' => $arrearsList,
    ]);
}

}
