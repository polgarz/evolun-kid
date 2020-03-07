<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use unclead\multipleinput\MultipleInput;
use unclead\multipleinput\MultipleInputColumn;
?>

<?php $form = ActiveForm::begin(); ?>
    <div class="box box-default">
        <div class="box-header">
            <h3 class="box-title"><?= Yii::t('kid', 'Base data') ?></h3>
        </div>

        <div class="box-body">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'family')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'birth_date')->widget(DatePicker::classname(), [
                'pluginOptions' => [
                    'autoclose'      => true,
                    'format'         => 'yyyy-mm-dd',
                    'todayHighlight' => true
                ]
            ]) ?>

            <?= $form->field($model, 'image', [
                'template' => '
                    {label}
                    ' . ($model->image ? '
                    <div id="profile_image" style="width: 100px; height: 100px; margin-bottom: 5px; background-image: url(' . $model->getThumbUploadUrl('image', 's') . ')">
                        <a href="javascript:;" onclick="$(\'#kidform-deleteprofileimage\').val(1);$(\'#profile_image\').remove();" class="btn close" style="padding: 0 3px" title="Profilkép törlése"><span aria-hidden="true">×</span></a>
                    </div>' : '') . '
                    {input}
                    {error}',
            ])->fileInput(['accept' => 'image/*']) ?>

            <?= $form->field($model, 'deleteProfileImage')->hiddenInput()->label(false) ?>

            <?= $form->field($model, 'inactive')->checkbox() ?>

            <?= $form->field($model, 'groups')->checkboxList($model::getKidGroupList(), ['separator' => '<br />']) ?>
        </div>
    </div>

    <div class="box box-default">
        <div class="box-header">
            <h3 class="box-title"><?= Yii::t('kid', 'Contact') ?></h3>
        </div>

        <div class="box-body">

            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'parent_contact')->textInput(['maxlength' => true]) ?>

        </div>
    </div>

    <div class="box box-default">
        <div class="box-header">
            <h3 class="box-title"><?= Yii::t('kid', 'School / Kindergarten') ?></h3>
        </div>

        <div class="box-body">

            <?= $form->field($model, 'school_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'class_number')->textInput() ?>

            <?= $form->field($model, 'educator_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'educator_phone')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'educator_office_hours')->textarea(['rows' => 6]) ?>

        </div>
    </div>

    <?php if ($extraFields = $model::getExtraFieldList()): ?>
        <div class="box box-default">
            <div class="box-header">
                <h3 class="box-title"><?= Yii::t('kid', 'Other') ?></h3>
            </div>

            <div class="box-body">
                <?php foreach ($extraFields as $extraField): ?>
                    <?php if ($extraField->type == 'textarea'): ?>
                        <?= $form->field($model, "extraFields[{$extraField->id}]")->textArea(['rows' => 3])->label($extraField->name) ?>
                    <?php elseif ($extraField->type == 'textinput'): ?>
                        <?= $form->field($model, "extraFields[{$extraField->id}]")->textInput()->label($extraField->name) ?>
                    <?php endif ?>
                <?php endforeach ?>
            </div>
        </div>
    <?php endif ?>

    <div class="box box-default">
        <div class="box-header">
            <h3 class="box-title"><?= Yii::t('kid', 'Responsibles') ?></h3>
        </div>

        <div class="box-body">

            <?= $form->field($model, 'responsibles')->widget(MultipleInput::className(), [
                'addButtonPosition' => MultipleInput::POS_FOOTER,
                'columns' => [
                    [
                        'name'  => 'responsible_id',
                        'type'  => MultipleInputColumn::TYPE_DROPDOWN,
                        'items' => $model::getResponsibleList()
                    ],
                    [
                        'name'  => 'user_id',
                        'type'  => MultipleInputColumn::TYPE_DROPDOWN,
                        'items' => $userList,
                        'options' => ['prompt' => '- Nincs kiválasztva -'],
                    ],
                ]
            ])->label(false)
?>

        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('kid', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
