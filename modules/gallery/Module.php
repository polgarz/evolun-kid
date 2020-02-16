<?php

namespace evolun\kid\modules\gallery;

use Yii;

/**
 * Gyerekek modulhoz tartozó galéria
 */
class Module extends \evolun\kid\modules\KidSubModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'evolun\kid\modules\gallery\controllers';

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
            $this->title = Yii::t('kid', 'Gallery');
        }

        parent::init();
    }
}
