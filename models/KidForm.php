<?php

namespace evolun\kid\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * A gyerekek adminisztraciojahoz (update, create) szukseges model
 */
class KidForm extends Kid
{
    /**
     * A csoportjai listaja
     * @var array
     */
    private $groups;

    /**
     * A felelosok
     * @var array
     */
    private $responsibles;

    /**
     * Az extra mezok
     * @var array
     */
    private $extraFields;

    /**
     * Torolje-e a profil kepet?
     * @var boolean
     */
    public $deleteProfileImage = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['groups', 'each', 'rule' => ['integer']],
            [['responsibles', 'extraFields'], 'safe'],
            ['deleteProfileImage', 'boolean'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'groups' => Yii::t('kid', 'Groups'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
            'inactive' => Yii::t('kid', 'If you check this, the kid\'s name won\'t show in lists, but nothing will be deleted.'),
        ];
    }

    /**
     * Visszaadja a gyerek csoportok listáját
     * @return array
     */
    public static function getKidGroupList()
    {
        return KidGroup::find()
            ->select('name')
            ->orderBy('order')
            ->indexBy('id')
            ->asArray()
            ->column();
    }

    /**
     * Visszaadja a gyerekhez tartozó extra mezők listáját
     * @return array
     */
    public static function getExtraFieldList()
    {
        return ExtraField::find()
            ->all();
    }

    /**
     * Visszaadja a felelősök listáját
     * @return array
     */
    public static function getResponsibleList()
    {
        return Responsible::find()
            ->select('name')
            ->indexBy('id')
            ->asArray()
            ->column();
    }

    /**
     * Mentes elott
     * @param  boolean $insert Insert tortenik-e?
     * @return boolean
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        // itt vizsgaljuk ezt a mezot, ha true, toroljuk a profil kepet (ezt a tulajdonsagot a formban allitjuk)
        if ($this->deleteProfileImage) {
            $this->image = null;
        }

        return true;
    }

    /**
     * Mentés
     * @param  boolean $runValidation  futtasson-e validációt
     * @param  array  $attributeNames milyen mezőkre?
     * @return boolean
     */
    public function save($runValidation = true, $attributeNames = NULL)
    {
        if (parent::save($runValidation, $attributeNames)) {
            if (!$this->isNewRecord) {
                KidGroupKid::deleteAll(['kid_id' => $this->id]);
                ResponsibleUser::deleteAll(['kid_id' => $this->id]);
                ExtraFieldValue::deleteAll(['kid_id' => $this->id]);
            }

            if (!empty($this->groups)) {
                foreach($this->groups as $group) {
                    $kidGroupKid = new KidGroupKid(['kid_group_id' => $group, 'kid_id' => $this->id]);
                    if ($kidGroupKid->validate()) {
                        $this->link('kidGroupKids', $kidGroupKid);
                    }
                }
            }

            if (!empty($this->responsibles)) {
                foreach($this->responsibles as $responsible) {
                    $responsibleUser = new ResponsibleUser(['responsible_id' => $responsible['responsible_id'] ?? null, 'user_id' => $responsible['user_id'] ?? null, 'kid_id' => $this->id]);
                    if ($responsibleUser->validate()) {
                        $this->link('responsibleUsers', $responsibleUser);
                    }
                }
            }

            if (!empty($this->extraFields)) {
                foreach($this->extraFields as $id => $value) {
                    $extraField = new ExtraFieldValue(['kid_extra_field_id' => $id, 'value' => $value, 'kid_id' => $this->id]);
                    if ($extraField->validate()) {
                        $this->link('extraFieldValues', $extraField);
                    }
                }
            }

            return true;
        }
    }

    /**
     * Visszaadja a gyerekhez tartozó extra mezőket
     * @return array
     */
    public function getExtraFields()
    {
        if (isset($this->extraFields)) {
            return $this->extraFields;
        }

        return ExtraFieldValue::find()
            ->select('value')
            ->where(['kid_id' => $this->id])
            ->indexBy('kid_extra_field_id')
            ->asArray()
            ->column();
    }

    /**
     * Beállítja a gyerekhez tarotóz extra mezőket
     * @param array $extraFields
     */
    public function setExtraFields($extraFields)
    {
        $this->extraFields = $extraFields;
    }

    /**
     * Visszaadja a gyerekhez tartozó felelősöket
     * @return array
     */
    public function getResponsibles()
    {
        if (isset($this->responsibles)) {
            return $this->responsibles;
        }

        return ResponsibleUser::find()
            ->where(['kid_id' => $this->id])
            ->indexBy('id')
            ->asArray()
            ->all();
    }

    /**
     * Beállítja a gyerekhez tartozó felelősöket
     * @param array $responsibles
     */
    public function setResponsibles($responsibles)
    {
        $this->responsibles = $responsibles;
    }

    /**
     * Visszaadja azokat a csoport id-kat, amikben a gyerek szerepel
     * @return array
     */
    public function getGroups()
    {
        if (isset($this->groups)) {
            return $this->groups;
        }

        return ArrayHelper::getColumn($this->kidGroupKids, 'kid_group_id');
    }

    /**
     * Beallitja a gorup id-kat
     * @param array $groups
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;
    }

}
