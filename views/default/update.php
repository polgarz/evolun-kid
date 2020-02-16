<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model evolun\user\models\User */

$this->title = Yii::t('kid', 'Update kid: {name}', ['name' => $model->name]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('kid', 'Kids'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('kid', 'Update');
$this->params['pageHeader'] = ['title' => $this->title];
?>

<?= $this->render('_form', [
    'model' => $model,
    'userList' => $userList,
]) ?>