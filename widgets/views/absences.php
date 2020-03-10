<?php
use yii\helpers\Url;
use yii\web\View;

$this->registerJsVar('container', '#' . $this->context->id);
$this->registerJs('
    $(container).find(".less").on("click", function() {
        $(container)
            .find("li")
            .not(":lt(3)")
            .addClass("hidden");
        $(this).addClass("hidden");
        $(container).find(".more").removeClass("hidden");
        return false;
    });

    $(container).find(".more").on("click", function() {
        $(container)
            .find("li")
            .removeClass("hidden");
        $(this).addClass("hidden");
        $(container).find(".less").removeClass("hidden");
        return false;
    });
    ', View::POS_READY);
?>
<?php if ($absences): ?>
    <div class="box box-default" id="<?= $this->context->id ?>">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Yii::t('kid/widget', 'Absences') ?></h3>
        </div>
        <div class="box-body">
            <ul class="list-group list-group-unbordered">
                <?php foreach ($absences as $i => $absence): ?>
                    <li class="list-group-item <?= ($i >= 3 ? 'hidden' : '') ?>">
                        <strong><?= $absence->event->title ?> (<?= $absence->event->dateSummary ?>)</strong>
                        <div class="text-muted">
                            <div><?= $absence->reason ?></div>
                        </div>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
        <?php if (count($absences) > 3): ?>
            <div class="box-footer">
                <a href="#" class="more"><?= Yii::t('kid/widget', 'Show more') ?></a>
                <a href="#" class="less hidden"><?= Yii::t('kid/widget', 'Show less') ?></a>
            </div>
        <?php endif ?>
    </div>
<?php endif ?>