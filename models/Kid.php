<?php

namespace evolun\kid\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "kid".
 *
 * @property int $id
 * @property string $name
 * @property string $family
 * @property string $birth_date
 * @property string $address
 * @property string $parent_contact
 * @property string $school_name
 * @property string $class_number
 * @property string $educator_name
 * @property string $educator_phone
 * @property string $educator_office_hours
 * @property int $inactive
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property User $updatedBy
 * @property User $createdBy
 * @property ExtraFieldValue[] $kidExtraFieldValues
 * @property KidGroupKid[] $kidGroupKs
 * @property ResponsibleUser[] $kidResponsibleUsers
 */
class Kid extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kid';
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
                'placeholder' => '@vendor/polgarz/evolun-kid/assets/profile-placeholder.png',
                'path' => Yii::$app->params['uploadBasePath'] . '/images/kid/{id}/profile',
                'url' => Yii::$app->params['uploadBaseUrl'] . '/images/kid/{id}/profile',
                'thumbs' => [
                    's'  => ['width' => 100, 'height' => 100, 'mode' => \Imagine\Image\ManipulatorInterface::THUMBNAIL_OUTBOUND],
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
            [['name'], 'required'],
            [['birth_date', 'created_at', 'updated_at', 'groups'], 'safe'],
            [['inactive', 'created_by', 'updated_by'], 'integer'],
            [['image'], 'image', 'skipOnEmpty' => true, 'extensions' => 'jpg, jpeg, gif, png'],
            [['educator_office_hours'], 'string'],
            [['name', 'family', 'address', 'parent_contact', 'school_name', 'educator_name', 'educator_phone', 'class_number', 'phone'], 'string', 'max' => 255],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Yii::$app->user->identityClass, 'targetAttribute' => ['updated_by' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Yii::$app->user->identityClass, 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('kid', 'Name'),
            'family' => Yii::t('kid', 'Family name'),
            'birth_date' => Yii::t('kid', 'Birth date'),
            'address' => Yii::t('kid', 'Address'),
            'address_lat' => Yii::t('kid', 'GPS lat'),
            'address_lon' => Yii::t('kid', 'GPS lon'),
            'school_name' => Yii::t('kid', 'School / Kindergarten name'),
            'class_number' => Yii::t('kid', 'Class nr. / Group name'),
            'educator_name' => Yii::t('kid', 'Educator name'),
            'educator_phone' => Yii::t('kid', 'Educator phone'),
            'educator_office_hours' => Yii::t('kid', 'Educator office hours'),
            'parent_contact' => Yii::t('kid', 'Parent contact'),
            'phone' => Yii::t('kid', 'Kid phone number'),
            'image' => Yii::t('kid', 'Profile image'),
            'inactive' => Yii::t('kid', 'Inactive'),
            'created_at' => Yii::t('kid', 'Created at'),
            'updated_at' => Yii::t('kid', 'Updated at'),
            'created_by' => Yii::t('kid', 'Created by'),
            'updated_by' => Yii::t('kid', 'Updated by'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'updated_by']);
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
    public function getExtraFieldValues()
    {
        return $this->hasMany(ExtraFieldValue::className(), ['kid_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKidGroupKids()
    {
        return $this->hasMany(KidGroupKid::className(), ['kid_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKidGroups()
    {
        return $this->hasMany(KidGroup::className(), ['id' => 'kid_group_id'])->via('kidGroupKids');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponsibleUsers()
    {
        return $this->hasMany(ResponsibleUser::className(), ['kid_id' => 'id']);
    }

    /**
     * Visszaadja a gyerek korát
     * @return integer|null
     */
    public function getAge()
    {
        if (!empty($this->birth_date)) {
            return floor((time() - strtotime($this->birth_date)) / 60 / 60 / 24 / 365);
        }
    }
}
