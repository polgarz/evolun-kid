<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = Yii::t('kid/responsibility', 'Update responsibility: {responsibility}', ['responsibility' => $model->name]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('kid/responsibility', 'Responsibilities'), 'url' => ['index']];
$this->params['pageHeader'] = ['title' => $this->title];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
]);
