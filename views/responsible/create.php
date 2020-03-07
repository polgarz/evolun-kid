<?php
$this->title = Yii::t('kid/responsibility', 'New responsibility');
$this->params['breadcrumbs'][] = ['label' => Yii::t('kid/responsibility', 'Responsibilities'), 'url' => ['index']];
$this->params['pageHeader'] = ['title' => $this->title];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
]);
