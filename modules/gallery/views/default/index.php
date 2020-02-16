<?php
use evolun\kid\modules\gallery\assets\KidGalleryAsset;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\web\View;

$this->registerJsVar('galleryImagesUrl', Url::to(['images', 'id' => $kid->id]));
$this->registerJsVar('galleryUploadUrl', Url::to(['upload', 'id' => $kid->id]));
$this->registerJsVar('galleryDeleteUrl', Url::to(['delete', 'id' => $kid->id]));
$this->registerJsVar('galleryRotateUrl', Url::to(['rotate', 'id' => $kid->id]));

KidGalleryAsset::register($this);
?>

<div id="gallery">
    <?php if (Yii::$app->user->can('manageKids', ['kid' => $kid])): ?>
        <p>
            <label class="btn btn-primary">
                <i class='fa fa-circle-o-notch fa-spin' v-if="uploadInProgress" v-cloak></i>
                <?= Yii::t('kid/gallery', 'Upload image...') ?>
                <input type="file" @change="uploadImage" class="hidden" accept="image/*" />
            </label>
        </p>
    <?php endif ?>

    <div class="alert alert-danger alert-dissmissible" v-if="error" v-cloak>
        <h4><i class="icon fa fa-ban"></i> <?= Yii::t('kid/gallery', 'Error') ?>!</h4>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {{error}}
    </div>

    <div class="row">
        <div class="col-xs-6 col-md-3" v-if="images && images.length > 0" v-for="image in images" v-cloak>
            <div class="thumbnail">
                <a :href="image.imageUrl" target="_blank">
                    <img :src="image.thumbnailUrl" alt="">
                </a>
                <?php if (Yii::$app->user->can('manageKids', ['kid' => $kid])): ?>
                    <div class="caption">
                        <a href="javascript:;" class="btn btn-sm btn-danger" v-on:click="deleteImage(image.id)"><i class="fa fa-trash"></i></a>
                        <a href="javascript:;" class="btn btn-sm btn-default" v-on:click="rotateImage(image.id, -90)"><i class="fa fa-rotate-left"></i></a>
                        <a href="javascript:;" class="btn btn-sm btn-default" v-on:click="rotateImage(image.id, 90)"><i class="fa fa-rotate-right"></i></a>
                        <div class="clearfix"></div>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
    <div class="text-muted" v-if="images && images.length == 0" v-cloak><p><?= Yii::t('kid/gallery', 'There are no images') ?></p></div>
</div>
