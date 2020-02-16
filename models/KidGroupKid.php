<?php

namespace evolun\kid\models;

use Yii;

/**
 * This is the model class for table "kid_group_kid".
 *
 * @property int $id
 * @property int $kid_group_id
 * @property int $kid_id
 *
 * @property Kid $kid
 * @property KidGroup $kidGroup
 */
class KidGroupKid extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kid_group_kid';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kid_group_id', 'kid_id'], 'required'],
            [['kid_group_id', 'kid_id'], 'integer'],
            [['kid_id'], 'exist', 'skipOnError' => true, 'targetClass' => Yii::$app->controller->module->kidModelClass, 'targetAttribute' => ['kid_id' => 'id']],
            [['kid_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => KidGroup::className(), 'targetAttribute' => ['kid_group_id' => 'id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKid()
    {
        return $this->hasOne(Yii::$app->controller->module->kidModelClass, ['id' => 'kid_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKidGroup()
    {
        return $this->hasOne(KidGroup::className(), ['id' => 'kid_group_id']);
    }
}
