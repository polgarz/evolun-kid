<?php

namespace evolun\kid\modules\notes\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;

/**
 * This is the model class for table "kid_note".
 *
 * @property int $id
 * @property string $title
 * @property string $note
 * @property int $kid_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property Kid $kid
 * @property User $createdBy
 * @property User $updatedBy
 */
class KidNote extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName() : string
    {
        return 'kid_note';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors() : array
    {
        return [
            ['class' => BlameableBehavior::className()],
            ['class' => TimestampBehavior::className(), 'value' => new \yii\db\Expression('NOW()')],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() : array
    {
        return [
            [['title', 'note', 'kid_id'], 'required'],
            [['note'], 'string'],
            [['kid_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['kid_id'], 'exist', 'skipOnError' => true, 'targetClass' => Yii::$app->controller->module->kidModelClass, 'targetAttribute' => ['kid_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Yii::$app->user->identityClass, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Yii::$app->user->identityClass, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() : array
    {
        return [
            'title' => Yii::t('kid/notes', 'Subject'),
            'note' => Yii::t('kid/notes', 'Note'),
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'updated_by']);
    }

    public function fields() : array
    {
        return [
            'id',
            'title',
            'note' => function ($model) {
                return nl2br($model->note);
            },
            'date' => function ($model) {
                return Yii::$app->formatter->asDate($model->created_at, 'long');
            },
            'createdBy' => function ($model) {
                return ($model->createdBy ? [
                    'name' => $model->createdBy->name,
                    'image' => $model->createdBy->getThumbUploadUrl('image', 's'),
                    'url' => Url::to(['/user/default/view', 'id' => $model->created_by])
                ] : null);
            },
        ];
    }
}
