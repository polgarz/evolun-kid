<?php
use yii\helpers\Url;
?>
<?php if ($responsibleUsers && Yii::$app->user->can('showUsers')): ?>
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Yii::t('kid/widget', 'Responsibles') ?></h3>
        </div>
        <div class="box-body">
            <ul class="list-group list-group-unbordered">
                <?php foreach ($responsibleUsers as $responsible): ?>
                    <li class="list-group-item">
                        <b><?= $responsible->responsible->name ?></b> <a href="<?= Url::to(['/user/default/view', 'id' => $responsible->user_id]) ?>" class="pull-right"><?= $responsible->user->name ?></a>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
<?php endif ?>