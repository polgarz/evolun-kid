<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use yii\bootstrap\Tabs;
use yii\helpers\Url;
use yii\helpers\StringHelper;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model evolun\user\models\User */

$this->title = $model->name . ' (' . $model->family . ')';
$this->params['breadcrumbs'][] = ['label' => Yii::t('kid', 'Kids'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['pageHeader'] = ['title' => '&nbsp;'];
?>
<div class="row">
    <div class="col-lg-3 col-md-4">

         <!-- Profile Image -->
        <div class="box box-default">
            <div class="box-body box-profile">
                <a href="<?= $model->image ? $model->getUploadUrl('image') : '#' ?>" <?= $model->image ? 'target="_blank"' : '' ?>><img class="profile-user-img img-responsive img-circle" src="<?= $model->getThumbUploadUrl('image', 's') ?>" alt="<?= Yii::t('kid', 'Profile image') ?>"></a>
                <h3 class="profile-username text-center"><?= $model->name ?></h3>

                <p class="text-muted text-center">
                    <?= implode(', ', ArrayHelper::getColumn($model->kidGroups, 'name')) ?>
                </p>

                <ul class="list-group list-group-unbordered">
                    <?php if ($model->family): ?>
                        <li class="list-group-item">
                            <b><?= $model->getAttributeLabel('family') ?></b> <span class="pull-right"><?= $model->family ?></span>
                        </li>
                    <?php endif ?>
                    <?php if ($model->birth_date): ?>
                        <li class="list-group-item">
                            <b><?= $model->getAttributeLabel('birth_date') ?></b> <span class="pull-right"><?= Yii::$app->formatter->asDate($model->birth_date) ?> (<?= Yii::t('kid', '{age} years old', ['age' => $model->age]) ?>)</span>
                        </li>
                    <?php endif ?>
                    <?php if ($model->address): ?>
                        <li class="list-group-item">
                            <b><?= $model->getAttributeLabel('address') ?></b> <a target="_blank" href="https://www.google.com/maps/place/<?= urlencode($model->address) ?>" class="pull-right"><?= StringHelper::truncate($model->address, 25) ?></a>
                        </li>
                    <?php endif ?>
                    <?php if ($model->updated_at): ?>
                        <li class="list-group-item">
                            <b><?= $model->getAttributeLabel('updated_at') ?></b> <span class="pull-right"><?= Yii::$app->formatter->asDate($model->updated_at) ?></span>
                        </li>
                    <?php endif ?>
                    <?php if ($model->updated_by && Yii::$app->user->can('showUsers')): ?>
                        <li class="list-group-item">
                            <b><?= $model->getAttributeLabel('updated_by') ?></b> <a href="<?= Url::to(['/user/default/view', 'id' => $model->updated_by]) ?>" class="pull-right"><?= $model->updatedBy->name ?></a>
                        </li>
                    <?php endif ?>
                </ul>

                <?php if (Yii::$app->user->can('manageKids', ['kid' => $model])): ?>
                    <div class="row">
                        <div class="col-xs-6">
                            <?= Html::a('<i class="fa fa-pencil"></i> ' . Yii::t('kid', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-block']) ?>
                        </div>
                        <div class="col-xs-6">
                            <?= Html::a('<i class="fa fa-trash"></i> ' . Yii::t('kid', 'Delete'), ['delete', 'id' => $model->id], ['class' => 'btn btn-danger btn-block', 'data-method' => 'post', 'data-confirm' => Yii::t('kid', 'Are you sure? Every data belongs this kid will be deleted!')]) ?>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </div>

        <?php if (!empty(Yii::$app->controller->module->widgets)): ?>
            <?php foreach(Yii::$app->controller->module->widgets as $widget): ?>
                <?= $widget::widget(['kid' => $model]) ?>
            <?php endforeach ?>
        <?php endif ?>
    </div>

    <!-- right col -->
    <div class="col-lg-9 col-md-8">
        <?php if ($modules): ?>
            <?php foreach($modules as $id => $module): ?>
                <?php $items[] = ['label' => $module['title'], 'content' => $module['content']] ?>
            <?php endforeach ?>

            <div class="nav-tabs-custom">
                <?= Tabs::widget([
                    'items' => $items,
                ]) ?>
            </div>
        <?php endif ?>
    </div>
</div>
