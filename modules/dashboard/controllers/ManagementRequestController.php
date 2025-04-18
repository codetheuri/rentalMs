<?php

namespace dashboard\controllers;

use Yii;
use dashboard\models\MaintenanceRequest;
use dashboard\models\searches\RequestSearches;
use helpers\DashboardController;
use yii\web\NotFoundHttpException;

/**
 * ManagementRequestController implements the CRUD actions for MaintenanceRequest model.
 */
class ManagementRequestController extends DashboardController
{
    public $permissions = [
        'dashboard-management-request-list'=>'View MaintenanceRequest List',
        'dashboard-management-request-create'=>'Add MaintenanceRequest',
        'dashboard-management-request-update'=>'Edit MaintenanceRequest',
        'dashboard-management-request-delete'=>'Delete MaintenanceRequest',
        'dashboard-management-request-restore'=>'Restore MaintenanceRequest',
        ];
    public function getViewPath()
    {
        return Yii::getAlias("@ui/views/ms/requests");
    }    
    public function actionIndex()
    {
        Yii::$app->user->can('dashboard-management-request-list');
        $searchModel = new RequestSearches();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCreate()
    {
        Yii::$app->user->can('dashboard-management-request-create');
        $model = new MaintenanceRequest();
        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'MaintenanceRequest created successfully');
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
        }else{
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    public function actionUpdate($id)
    {
        Yii::$app->user->can('dashboard-management-request-update');
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'MaintenanceRequest updated successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        }
        if ($this->request->isAjax) {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }else{
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    public function actionTrash($id)
    {
        $model = $this->findModel($id);
        if ($model->is_deleted) {
            Yii::$app->user->can('dashboard-management-request-restore');
            $model->restore();
            Yii::$app->session->setFlash('success', 'MaintenanceRequest has been restored');
        } else {
            Yii::$app->user->can('dashboard-management-request-delete');
            $model->delete();
            Yii::$app->session->setFlash('success', 'MaintenanceRequest has been deleted');
        }
        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = MaintenanceRequest::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
