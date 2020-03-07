<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use evolun\kid\models\ExtraField;

/* @var $this yii\web\View */
/* @var $model app\models\Workgroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-default">

    <div class="box-body">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput() ?>

        <?= $form->field($model, 'type')->dropdownList(ExtraField::getTypeList()) ?>

        <div class="form-group">
            <?= Html::submitButton('Mentés', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
