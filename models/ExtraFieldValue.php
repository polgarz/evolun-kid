<?php

namespace evolun\kid\models;

use Yii;

/**
 * This is the model class for table "kid_extra_field_value".
 *
 * @property int $id
 * @property int $kid_extra_field_id
 * @property int $kid_id
 * @property string $value
 *
 * @property Kid $kid
 * @property KidExtraField $kidExtraField
 */
class ExtraFieldValue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kid_extra_field_value';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kid_extra_field_id', 'kid_id', 'value'], 'required'],
            [['kid_extra_field_id', 'kid_id'], 'integer'],
            [['value'], 'string'],
            [['kid_id'], 'exist', 'skipOnError' => true, 'targetClass' => Yii::$app->controller->module->kidModelClass, 'targetAttribute' => ['kid_id' => 'id']],
            [['kid_extra_field_id'], 'exist', 'skipOnError' => true, 'targetClass' => ExtraField::className(), 'targetAttribute' => ['kid_extra_field_id' => 'id']],
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
    public function getExtraField()
    {
        return $this->hasOne(ExtraField::className(), ['id' => 'kid_extra_field_id']);
    }
}
