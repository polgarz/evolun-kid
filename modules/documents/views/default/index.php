<?php
use evolun\kid\modules\documents\assets\DocumentsAsset;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;

$this->registerJsVar('documentListUrl', Url::to(['documents', 'id' => $kid->id]));
$this->registerJsVar('documentUploadUrl', Url::to(['upload', 'id' => $kid->id]));
$this->registerJsVar('documentDeleteUrl', Url::to(['delete', 'id' => $kid->id]));

DocumentsAsset::register($this);
?>

<div id="documents">
    <div class="alert alert-danger alert-dissmissible" v-if="errors.length" v-cloak>
        <h4><i class="icon fa fa-ban"></i> <?= Yii::t('kid/documents', 'Error') ?>!</h4>
        <div v-for="error in errors">{{error}}</div>
    </div>

    <div class="list-group" v-if="documents && documents.length > 0">
        <a :href="document.url" target="_blank" class="list-group-item" v-for="document in documents" v-cloak>
            <div class="media">
                <div class="media-left media-middle">
                    <i class="fa fa-2x fa-file-pdf-o" v-if="document.extension=='pdf'"></i>
                    <i class="fa fa-2x fa-file-excel-o" v-else-if="document.extension=='xls'"></i>
                    <i class="fa fa-2x fa-file-word-o" v-else-if="document.extension=='doc' || document.extension=='docx'"></i>
                    <i class="fa fa-2x fa-file-o" v-else></i>
                </div>
                <div class="media-body">
                    <strong>{{document.name}}</strong><br />
                    <span>{{document.date}}</span><span v-if="document.createdBy"> &bullet; {{document.createdBy}}</span>
                </div>
                <?php if (Yii::$app->user->can('manageKids', ['kid' => $kid])): ?>
                    <div class="media-right media-middle">
                        <span>
                            <button class="btn btn-danger btn-sm" v-on:click="deleteDocument($event, document.id)">
                                <i class="fa fa-trash"></i>
                            </button>
                        </span>
                    </div>
                <?php endif ?>
            </div>
        </a>
    </div>

    <div class="text-muted" v-if="documents && documents.length == 0" v-cloak><p><?= Yii::t('kid/documents', 'There are no documents') ?></p></div>

    <?php if (Yii::$app->user->can('manageKids', ['kid' => $kid])): ?>
        <p><strong><?= Yii::t('kid/documents', 'Upload document') ?></strong></p>
        <!-- uj dokumentum -->
        <div>
            <?= Html::beginForm(null, 'post', ['v-on:submit' => 'uploadDocument', 'v-on:submit.prevent' => true]) ?>

            <div class="form-group">
                <?= Html::activeTextInput($model, 'name', ['v-model' => 'form.name', 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('name')]) ?>
                <div class="help-block"></div>
            </div>

            <div class="form-group">
                <?= Html::activeFileInput($model, 'file', ['@change' => 'processFile']) ?>
            </div>

            <?= Html::submitButton(Yii::t('kid/documents', 'Upload'), ['class' => 'btn btn-success']) ?>

            <?= Html::endForm() ?>
        </div>
    <?php endif ?>
</div>