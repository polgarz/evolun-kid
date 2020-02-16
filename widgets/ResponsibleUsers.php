<?php
namespace evolun\kid\widgets;

use Yii;
use evolun\kid\models\ResponsibleUser;

/**
 * A felelos felhasznalok listaja
 */
class ResponsibleUsers extends \yii\base\Widget implements KidWidgetInterface
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
        if (!Yii::$app->user->can('showUsers')) {
            return null;
        }

        $responsibleUsers = ResponsibleUser::find()
            ->where(['kid_id' => $this->getKid()->id])
            ->all();

        return $this->render('responsible-users', [
            'responsibleUsers' => $responsibleUsers,
            ]);
    }

    public function getKid()
    {
        return $this->kid;
    }
}
