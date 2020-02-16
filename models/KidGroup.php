<?php

namespace evolun\kid\models;

use Yii;

/**
 * This is the model class for table "kid_group".
 *
 * @property int $id
 * @property string $name
 *
 * @property KidGroupKid[] $kidGroupKs
 */
class KidGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kid_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
            [['order'], 'integer'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKidGroupKids()
    {
        return $this->hasMany(KidGroupKid::className(), ['kid_group_id' => 'id']);
    }
}
