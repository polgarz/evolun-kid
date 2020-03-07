<?php
use yii\helpers\Html;
?>
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Yii::t('kid/widget', 'Other data') ?></h3>
    </div>
    <div class="box-body">
        <?php if (!empty($kid->parent_contact)): ?>
            <strong><i class="fa fa-book margin-r-5"></i> <?= $kid->getAttributeLabel('parent_contact') ?></strong>
            <div class="text-muted">
                <div><?= $kid->parent_contact ?></div>
            </div>
        <?php endif ?>

        <?php if (!empty($kid->school_name) || !empty($kid->educator_name) || !empty($kid->educator_office_hours) || !empty($kid->educator_phone)): ?>
            <hr />
            <strong><i class="fa fa-building-o margin-r-5"></i> Iskola / Óvoda</strong>
            <div class="text-muted">
                <div><?= $kid->school_name ?> (<?= (is_numeric($kid->class_number) ? Yii::t('kid/widget', '{class_number}. class', ['class_number' => $kid->class_number]) : Yii::t('kid/widget', '{class_number}. group', ['class_number' => $kid->class_number])) ?>)</div>
                <div><?= $kid->educator_name ?></div>
                <div><?= $kid->educator_phone ?></div>
                <div><?= nl2br($kid->educator_office_hours) ?></div>
            </div>
        <?php endif ?>

        <?php foreach ($kid->extraFieldValues as $extraFieldValue): ?>
            <hr />
            <strong><?= $extraFieldValue->extraField->name ?></strong>
            <p class="text-muted">
                <?= nl2br(Html::encode($extraFieldValue->value)) ?>
            </p>
        <?php endforeach ?>

    </div>
</div>