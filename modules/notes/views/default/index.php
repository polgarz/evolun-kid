<?php
use evolun\kid\modules\notes\assets\NotesAsset;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;

$this->registerJsVar('noteListUrl', Url::to(['notes', 'id' => $kid->id]));
$this->registerJsVar('noteCreateUrl', Url::to(['create', 'id' => $kid->id]));
$this->registerJsVar('noteDeleteUrl', Url::to(['delete', 'id' => $kid->id]));

NotesAsset::register($this);
?>
<div id="notes">
    <div class="alert alert-danger alert-dissmissible" v-if="errors.length" v-cloak>
        <h4><i class="icon fa fa-ban"></i> <?= Yii::t('kid', 'Error') ?>!</h4>
        <div v-for="error in errors">{{error}}</div>
    </div>

    <div class="post" v-for="note in data.items" v-cloak v-if="data.items && data.items.length > 0">
        <div class="user-block">
            <img class="img-circle img-bordered-sm" :src="note.createdBy.image" alt="Profilkép" v-if="note.createdBy">
            <img src="https://via.placeholder.com/100x100?text=%3F" class="img-circle img-bordered-sm" alt="Profilkép" v-else>
            <span class="username">
                <a :href="note.createdBy.url" v-if="note.createdBy">{{note.createdBy.name}}</a>
                <span v-else><?= Yii::t('kid/notes', 'Deleted user') ?></span>
                <?php if (Yii::$app->user->can('manageKids', ['kid' => $kid])): ?>
                    <a href="#" v-on:click="deleteNote($event, note.id)" class="pull-right btn-box-tool">
                        <i class="fa fa-trash"></i>
                    </a>
                <?php endif ?>
            </span>
            <span class="description">{{note.date}}</span>
        </div>

        <h4>{{note.title}}</h4>
            <p v-html="note.note">
        </p>
    </div>

    <paginate
        v-model="page"
        v-if="data.pagination.pageCount > 1"
        :page-count="data.pagination.pageCount"
        :click-handler="loadData"
        :prev-text="'&laquo;'"
        :next-text="'&raquo;'"
        :container-class="'pagination'">
    </paginate>

    <div class="text-muted" v-if="data.items && data.items.length == 0" v-cloak><p><?= Yii::t('kid/notes', 'There are no notes') ?></p></div>

    <?php if (Yii::$app->user->can('manageKids', ['kid' => $kid])): ?>
        <p><strong><?= Yii::t('kid/notes', 'New note') ?></strong></p>
        <!-- uj poszt -->
        <div>
            <?= Html::beginForm(null, 'post', ['v-on:submit' => 'createNote', 'v-on:submit.prevent' => true]) ?>

            <div class="form-group">
                <?= Html::activeTextInput($model, 'title', ['v-model' => 'form.title', 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('title')]) ?>
                <div class="help-block"></div>
            </div>

            <div class="form-group">
                <?= Html::activeTextarea($model, 'note', ['v-model' => 'form.note', 'class' => 'form-control', 'rows' => 6, 'placeholder' => $model->getAttributeLabel('note')]) ?>
            </div>

            <?= Html::submitButton(Yii::t('kid/notes', 'Submit'), ['class' => 'btn btn-success']) ?>

            <?= Html::endForm() ?>
        </div>
    <?php endif ?>
</div>