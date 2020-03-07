<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = Yii::t('kid/extra-field', 'Update field: {field}', ['field' => $model->name]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('kid/extra-field', 'Extra fields'), 'url' => ['index']];
$this->params['pageHeader'] = ['title' => $this->title];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
]);
