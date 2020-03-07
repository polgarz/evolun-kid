<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Workgroup */

$this->title = Yii::t('kid/group', 'Update group: {group}', ['group' => $model->name]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('kid/group', 'Groups'), 'url' => ['index']];
$this->params['pageHeader'] = ['title' => $this->title];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
]);
