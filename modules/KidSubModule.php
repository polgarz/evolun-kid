<?php

namespace evolun\kid\modules;

use Yii;

/**
 * Gyerekhez tartozó al modulok fő modulja
 */
class KidSubModule extends \yii\base\Module
{
    /**
     * A modul neve (ami megjelenik a tabon is)
     * @var string
     */
    public $title;

    /**
     * Csak a tömbben szereplő kid group id-ban lévő gyerekeknél jelenik meg a modul
     * @var array
     */
    public $allowedGroupIds = [];

    /**
     * A gyerek modelje (a fő modulból)
     * @var Kid
     */
    private $_kid;

    public function getKid()
    {
        return $this->_kid;
    }

    public function setKid($kid)
    {
        $this->_kid = $kid;
    }

    public function init()
    {
        // beallitjuk a gyereket
        $kidModelClass = $this->module->kidModelClass;
        if ($kid = $kidModelClass::findOne(Yii::$app->request->get('id'))) {
            $this->setKid($kid);
        } else {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        parent::init();
    }
}
