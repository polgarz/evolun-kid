<?php

namespace evolun\kid\models;

use Yii;

/**
 * This is the model class for table "kid_extra_field".
 *
 * @property int $id
 * @property string $name
 * @property string $type
 *
 * @property ExtraFieldValue[] $kidExtraFieldValues
 */
class ExtraField extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kid_extra_field';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExtraFieldValues()
    {
        return $this->hasMany(ExtraFieldValue::className(), ['kid_extra_field_id' => 'id']);
    }
}
