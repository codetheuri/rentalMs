<?php

namespace dashboard\controllers;

use Yii;
use dashboard\models\Property;
use dashboard\models\searches\PropertySearch;
use helpers\DashboardController;
use dashboard\models\Unit;
use yii\web\NotFoundHttpException;

/**
 * PropertyController implements the CRUD actions for Property model.
 */
class PropertyController extends DashboardController
{
    public $permissions = [
        'dashboard-property-list'=>'View Property List',
        'dashboard-property-create'=>'Add Property',
        'dashboard-property-update'=>'Edit Property',
        'dashboard-property-delete'=>'Delete Property',
        'dashboard-property-restore'=>'Restore Property',
        ];
    public function getViewPath()
    {
        return Yii::getAlias("@ui/views/ms/property");
    }    
    public function actionIndex()
    {
        Yii::$app->user->can('dashboard-property-list');
        $searchModel = new PropertySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    // public function actionCreate()
    // {
    //     Yii::$app->user->can('dashboard-property-create');
    //     $model = new Property();
    //     if ($this->request->isPost) {
    //         if ($model->load(Yii::$app->request->post())) {
    //             if ($model->validate()) {
    //                 if ($model->save()) {
    //                     Yii::$app->session->setFlash('success', 'Property created successfully');
    //                     return $this->redirect(['index']);
    //                 }
    //             }
    //         }
    //     } else {
    //         $model->loadDefaultValues();
    //     }
    //    if ($this->request->isAjax) {
    //         return $this->renderAjax('create', [
    //             'model' => $model,
    //         ]);
    //     }else{
    //         return $this->render('create', [
    //             'model' => $model,
    //         ]);
    //     }
    // }
    public function actionCreate()
{
    Yii::$app->user->can('dashboard-property-create');
    $model = new Property();

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        // Now create units if number_of_units is provided
        if (!empty($model->number_of_units) && is_numeric($model->number_of_units)) {
            for ($i = 1; $i <= $model->number_of_units; $i++) {
                $unit = new Unit();
                $unit->property_id = $model->id;
                $unit->unit_number = $model->name.' Unit ' . $i;
                $unit->monthly_rent = $model->monthly_rent; // Or set a default or inherit from property if you want
                $unit->status_id = 8; // Set a default status (like "Available")
                $unit->save(false); // skip validation if it's safe
            }
        }

        Yii::$app->session->setFlash('success', 'Property and units created successfully.');
        return $this->redirect(['index']);
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
        Yii::$app->user->can('dashboard-property-update');
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Property updated successfully');
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
            Yii::$app->user->can('dashboard-property-restore');
            $model->restore();
            Yii::$app->session->setFlash('success', 'Property has been restored');
        } else {
            Yii::$app->user->can('dashboard-property-delete');
            $model->delete();
            Yii::$app->session->setFlash('success', 'Property has been deleted');
        }
        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = Property::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
