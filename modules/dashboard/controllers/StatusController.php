<?php

namespace dashboard\controllers;

use Yii;
use dashboard\models\Status;
use dashboard\models\searches\StatusSearch;
use helpers\DashboardController;
use yii\web\NotFoundHttpException;

/**
 * StatusController implements the CRUD actions for Status model.
 */
class StatusController extends DashboardController
{
    public $permissions = [
        'dashboard-status-list'=>'View Status List',
        'dashboard-status-create'=>'Add Status',
        'dashboard-status-update'=>'Edit Status',
        'dashboard-status-delete'=>'Delete Status',
        'dashboard-status-restore'=>'Restore Status',
        ];
    public function getViewPath()
    {
        return Yii::getAlias("@ui/views/ms/status");
    }
    public function actionIndex()
    {
        Yii::$app->user->can('dashboard-status-list');
        $searchModel = new StatusSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCreate()
    {
        Yii::$app->user->can('dashboard-status-create');
        $model = new Status();
        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Status created successfully');
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
        Yii::$app->user->can('dashboard-status-update');
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Status updated successfully');
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
            Yii::$app->user->can('dashboard-status-restore');
            $model->restore();
            Yii::$app->session->setFlash('success', 'Status has been restored');
        } else {
            Yii::$app->user->can('dashboard-status-delete');
            $model->delete();
            Yii::$app->session->setFlash('success', 'Status has been deleted');
        }
        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = Status::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
