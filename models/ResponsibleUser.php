<?php

namespace evolun\kid\models;

use Yii;

/**
 * This is the model class for table "kid_responsible_user".
 *
 * @property int $id
 * @property int $responsible_id
 * @property int $user_id
 * @property int $kid_id
 *
 * @property Kid $kid
 * @property KidResponsible $responsible
 * @property User $user
 */
class ResponsibleUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kid_responsible_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['responsible_id', 'user_id', 'kid_id'], 'required'],
            [['responsible_id', 'user_id', 'kid_id'], 'integer'],
            [['kid_id'], 'exist', 'skipOnError' => true, 'targetClass' => Yii::$app->controller->module->kidModelClass, 'targetAttribute' => ['kid_id' => 'id']],
            [['responsible_id'], 'exist', 'skipOnError' => true, 'targetClass' => Responsible::className(), 'targetAttribute' => ['responsible_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Yii::$app->user->identityClass, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKid()
    {
        return $this->hasOne(Kid::className(), ['id' => 'kid_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponsible()
    {
        return $this->hasOne(Responsible::className(), ['id' => 'responsible_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'user_id']);
    }
}
