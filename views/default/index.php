<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('kid', 'Kids');
$this->params['pageHeader'] = ['title' => $this->title];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-default">

    <div class="box-header">
        <div class="box-tools">
            <?= $this->render('_tools', ['searchModel' => $searchModel]) ?>
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
                    'value' => function($model) {
                        $summary = [];
                        if ($model->age !== null) {
                            $summary[] = Yii::t('kid', '{age} years old', ['age' => $model->age]);
                        }
                        if ($model->kidGroups) {
                            $summary[] = implode(', ', ArrayHelper::getColumn($model->kidGroups, 'name'));
                        }

                        $layout = '
                            <a href="{url}" class="text-default">
                                <div class="media">
                                    <div class="media-left media-middle">
                                        <img src="{image}" class="img-circle" width="40" />
                                    </div>
                                    <div class="media-body">
                                        {name}
                                        <div class="text-muted">
                                            {summary}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        ';

                        return strtr($layout, [
                            '{image}' => $model->getThumbUploadUrl('image', 's'),
                            '{name}' => $model->inactive ? Html::tag('strong', '<i class="fa fa-clock-o" title="' . Yii::t('kid', 'Inactive') . '"></i> ' . $model->name . ' (' . $model->family . ')', ['class' => 'text-muted']) : Html::tag('strong', $model->name . ' (' . $model->family . ')'),
                            '{summary}' => implode(', ', $summary),
                            '{url}' => Url::to(['view', 'id' => $model->id]),
                        ]);
                    }
                ],
            ],
        ]); ?>
    </div>
</div>

