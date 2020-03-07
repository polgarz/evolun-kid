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
    const TYPE_TEXTAREA = 'textarea';
    const TYPE_TEXTINPUT = 'textinput';

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
            [['name', 'type'], 'required'],
            ['type', 'in', 'range' => array_keys(self::getTypeList())],
            [['name', 'type'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => Yii::t('kid/extra-field', 'Name'),
            'type' => Yii::t('kid/extra-field', 'Type'),
        ];
    }

    public static function getTypeList()
    {
        return [
            self::TYPE_TEXTINPUT => Yii::t('kid/extra-field', 'Textinput'),
            self::TYPE_TEXTAREA => Yii::t('kid/extra-field', 'Textarea'),
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
