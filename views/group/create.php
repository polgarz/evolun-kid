<?php
$this->title = Yii::t('kid/group', 'Create group');
$this->params['breadcrumbs'][] = ['label' => Yii::t('kid/group', 'Groups'), 'url' => ['index']];
$this->params['pageHeader'] = ['title' => $this->title];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
]);
