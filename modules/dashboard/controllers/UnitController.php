<?php

namespace dashboard\controllers;

use Yii;
use dashboard\models\Unit;
use dashboard\models\searches\UnitSearch;
use helpers\DashboardController;
use yii\web\NotFoundHttpException;

/**
 * UnitController implements the CRUD actions for Unit model.
 */
class UnitController extends DashboardController
{
    public $permissions = [
        'dashboard-unit-list'=>'View Unit List',
        'dashboard-unit-create'=>'Add Unit',
        'dashboard-unit-update'=>'Edit Unit',
        'dashboard-unit-delete'=>'Delete Unit',
        'dashboard-unit-restore'=>'Restore Unit',
        ];
    public function getViewPath()
    {
        return Yii::getAlias("@ui/views/ms/unit");
    }
    public function actionIndex()
    {
        Yii::$app->user->can('dashboard-unit-list');
        $searchModel = new UnitSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCreate()
    {
        Yii::$app->user->can('dashboard-unit-create');
        $model = new Unit();
        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Unit created successfully');
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
        Yii::$app->user->can('dashboard-unit-update');
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Unit updated successfully');
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
            Yii::$app->user->can('dashboard-unit-restore');
            $model->restore();
            Yii::$app->session->setFlash('success', 'Unit has been restored');
        } else {
            Yii::$app->user->can('dashboard-unit-delete');
            $model->delete();
            Yii::$app->session->setFlash('success', 'Unit has been deleted');
        }
        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = Unit::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
