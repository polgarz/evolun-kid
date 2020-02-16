<?php

namespace evolun\kid\models;

use Yii;

/**
 * This is the model class for table "kid_responsible".
 *
 * @property int $id
 * @property string $name
 *
 * @property KidResponsibleUser[] $kidResponsibleUsers
 */
class Responsible extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kid_responsible';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponsibleUsers()
    {
        return $this->hasMany(ResponsibleUser::className(), ['responsible_id' => 'id']);
    }
}
