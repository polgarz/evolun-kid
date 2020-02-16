<?php

namespace evolun\kid\modules\notes;

use Yii;
use evolun\kid\KidModuleInterface;

/**
 * Gyerekek modulhoz tartozó jegyzetek modul
 */
class Module extends \evolun\kid\modules\KidSubModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'evolun\kid\modules\notes\controllers';

    /**
     * A gyerekek modelje
     * @var string
     */
    public $kidModelClass = 'evolun\kid\models\Kid';

    public function init()
    {
        if (!class_exists($this->kidModelClass)) {
            throw new InvalidConfigException(Yii::t('kid', 'Kid model class not found!'));
        }

        if (!$this->title) {
            $this->title = Yii::t('kid', 'Notes');
        }

        parent::init();
    }
}
