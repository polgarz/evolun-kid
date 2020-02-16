<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<?php if (Yii::$app->user->can('manageKids')): ?>
    <?= Html::a('<i class="fa fa-plus"></i> ' . Yii::t('kid', 'New kid'), ['create'], ['class' => 'btn btn-success pull-left', 'style' => 'margin-right: 5px']) ?>
<?php endif ?>

<div class="btn-group pull-left" style="margin-right: 5px">
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php if ($searchModel->validate() && $searchModel->group): ?>
            <?= $searchModel->groupList[$searchModel->group] ?>
        <?php else: ?>
            <?= Yii::t('kid', 'Group') ?>
        <?php endif ?>
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li><a href="javascript:;" onclick="$('#kidsearch-group').val('');$('#kid-search-form').submit();"><?= Yii::t('kid', 'All group') ?></a></li>
        <?php foreach($searchModel->groupList as $id => $name): ?>
            <li><a href="javascript:;" onclick="$('#kidsearch-group').val('<?= $id ?>');$('#kid-search-form').submit();"><?= $name ?></a></li>
        <?php endforeach ?>
    </ul>
</div>

<?php $form = ActiveForm::begin(['method' => 'get', 'id' => 'kid-search-form', 'action' => ['index']]) ?>
    <div class="input-group">
        <?= $form->field($searchModel, 'searchString', ['options' => ['tag' => false], 'inputOptions' => ['placeholder' => Yii::t('kid', 'Search by name, family name, or other data')]])->label(false) ?>
        <div class="input-group-btn">
            <?= Html::submitButton('<i class="fa fa-search"></i>', ['class' => 'btn btn-default']) ?>
            <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#advancedSearch" aria-expanded="false" aria-controls="advancedSearch">
                <i class="fa fa-angle-down"></i>
            </button>
        </div>
    </div>
    <?= $form->field($searchModel, 'group', ['options' => ['tag' => false]])->hiddenInput()->label(false)->hint(false)->error(false) ?>

    <div class="collapse" id="advancedSearch">
        <h3><?= Yii::t('kid', 'Advanced search') ?></h3>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($searchModel, 'ageFrom') ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($searchModel, 'ageTo') ?>
            </div>
        </div>
        <?= $form->field($searchModel, 'address') ?>
        <?= Html::submitButton(Yii::t('kid', 'Search'), ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end() ?>
