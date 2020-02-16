<?php
namespace evolun\kid\widgets;

use Yii;
use evolun\kid\models\ResponsibleUser;

/**
 * A gyerek egyeb adatainak listaja
 */
class OtherData extends \yii\base\Widget implements KidWidgetInterface
{
    /**
     * A gyerek
     * @var Kid
     */
    public $kid;

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('other-data', [
            'kid' => $this->getKid(),
            ]);
    }

    public function getKid()
    {
        return $this->kid;
    }
}
