<?php

namespace evolun\kid\modules\documents\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "kid_document".
 *
 * @property int $id
 * @property int|null $kid_id
 * @property string|null $name
 * @property string|null $file
 * @property string|null $created_at
 * @property int|null $created_by
 *
 * @property Kid $kid
 * @property User $createdBy
 */
class KidDocument extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kid_document';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            ['class' => BlameableBehavior::className(), 'updatedByAttribute' => false],
            ['class' => TimestampBehavior::className(), 'value' => new \yii\db\Expression('NOW()'), 'updatedAtAttribute' => false],
            [
                'class' => \mohorev\file\UploadBehavior::class,
                'attribute' => 'file',
                'scenarios' => ['default'],
                'path' => Yii::$app->params['uploadBasePath'] . '/images/kid/{kid_id}/documents',
                'url' => Yii::$app->params['uploadBaseUrl'] . '/images/kid/{kid_id}/documents',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kid_id', 'name', 'file'], 'required'],
            [['kid_id', 'created_by'], 'integer'],
            [['created_at'], 'safe'],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'doc,docx,xls,pdf'],
            [['name'], 'string', 'max' => 255],
            [['kid_id'], 'exist', 'skipOnError' => true, 'targetClass' => Yii::$app->controller->module->kidModelClass, 'targetAttribute' => ['kid_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Yii::$app->user->identityClass, 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('kid/documents', 'Name'),
            'file' => Yii::t('kid/documents', 'File'),
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
    public function getCreatedBy()
    {
        return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'created_by']);
    }
}
