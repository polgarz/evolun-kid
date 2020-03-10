<?php
namespace evolun\kid\widgets;

use Yii;

class Absences extends \yii\base\Widget implements KidWidgetInterface
{
    /**
     * @var Kid
     */
    public $kid = false;

    /**
     * @var string
     */
    public $eventModuleId = 'event';

    /**
     * @var string
     */
    public $kidModuleId = 'kid';

    /**
     * @var string
     */
    public $absenceModel = 'evolun\event\modules\absence\models\Absence';


    public function getKid()
    {
        return $this->kid;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if (!Yii::$app->hasModule($this->eventModuleId)) {
            throw new \yii\base\InvalidConfigException('You have to install \'evolun-event\' to use this widget');
        }

        $absences = $this->absenceModel::find()
            ->joinWith('event')
            ->where(['kid_id' => $this->getKid()->id])
            ->orderBy('event.start DESC')
            ->all();

        return $this->render('absences', [
            'absences' => $absences,
            ]);
    }
}
