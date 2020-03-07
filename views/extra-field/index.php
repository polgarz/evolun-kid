<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('kid/extra-field', 'Extra fields');
$this->params['pageHeader'] = ['title' => $this->title];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-default">

    <div class="box-header">
        <div class="box-tools pull-left">
            <?= Html::a('<i class="fa fa-plus"></i> ' . Yii::t('kid/extra-field', 'New field'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <div class="box-body table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'showHeader' => false,
            'tableOptions' => ['class' => 'table table-hover'],
            'layout' => '{items}{summary}{pager}',
            'columns' => [
                [
                    'attribute' => 'name',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return Html::a($model->name, ['update', 'id' => $model->id], ['class' => 'col-link text-default']);
                    },
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['style' => 'width: 65px', 'class' => 'text-right'],
                    'template' => '{delete}',
                    'buttons' => [
                        'delete' => function ($url, $model) {
                            return Html::a('<i class="fa fa-trash"></i>', $url, ['class' => 'btn btn-default btn-xs', 'data-method' => 'post', 'data-confirm' => Yii::t('kid', 'Are you sure?')]);
                        },
                    ],
                ],
            ],
        ]); ?>
    </div>
</div>
