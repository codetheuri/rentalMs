<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use Yii;

/** @var yii\web\View $this */
/** @var dashboard\models\searches\TenancySearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="clearfix">
    <div class="float-start">
         <?= Html::dropDownList('per-page',
        isset(Yii::$app->request->queryParams['per-page']) ? Yii::$app->request->queryParams['per-page'] : 25,
        Yii::$app->params['pageSize'],
        ['class'=>'form-select form-select-sm'])
        ?>

    </div>
    <div class="float-end">
        <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
                ]); ?>

         <?=  $form->field($model, 'globalSearch', [
        'template' => '<div class="input-group input-group-sm">{input}
            <button type="submit" class="btn btn-primary btn-sm"> <i class="fa fa-fw fa-search"></i></button>
        </div>{error}{hint}'
        ])->textInput(['placeholder' => "Search...",'class'=>"form-control form-control-alt"])->label(false); ?>

        <?php ActiveForm::end(); ?>

    </div>
</div>