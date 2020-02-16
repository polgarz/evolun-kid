<?php

namespace evolun\kid\modules\gallery\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\imagine\Image;

/**
 * This is the model class for table "kid_image".
 *
 * @property int $id
 * @property int $kid_id
 * @property string $image
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property Kid $kid
 * @property User $createdBy
 * @property User $updatedBy
 */
class KidImage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kid_image';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            ['class' => BlameableBehavior::className()],
            ['class' => TimestampBehavior::className(), 'value' => new \yii\db\Expression('NOW()')],
            [
                'class' => \mohorev\file\UploadImageBehavior::class,
                'attribute' => 'image',
                'scenarios' => ['default'],
                'path' => Yii::$app->params['uploadBasePath'] . '/images/kid/{kid_id}/gallery',
                'url' => Yii::$app->params['uploadBaseUrl'] . '/images/kid/{kid_id}/gallery',
                'thumbs' => [
                    's'  => ['width' => 200, 'height' => 200, 'mode' => \Imagine\Image\ManipulatorInterface::THUMBNAIL_OUTBOUND],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kid_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['image'], 'image', 'skipOnEmpty' => true, 'extensions' => 'jpg, jpeg, gif, png'],
            [['kid_id'], 'exist', 'skipOnError' => true, 'targetClass' => Yii::$app->controller->module->kidModelClass, 'targetAttribute' => ['kid_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Yii::$app->user->identityClass::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Yii::$app->user->identityClass::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kid_id' => 'Kid ID',
            'image' => 'Image',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Forgat egy képet
     * @param  int $degree Fok
     * @return boolean
     */
    public function rotateImage($degree)
    {
        // original
        $image = Image::getImagine()->open($this->getUploadPath('image'));
        $image->rotate($degree)
            ->save($this->getUploadPath('image'));

        // thumbnail
        $image = Image::getImagine()->open($this->getThumbUploadPath('image', 's'));
        $image->rotate($degree)
            ->save($this->getThumbUploadPath('image', 's'));

        return true;
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'updated_by']);
    }
}
