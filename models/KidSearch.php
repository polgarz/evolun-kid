<?php

namespace evolun\kid\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * A gyerekek kereséséhez szükséges model
 */
class KidSearch extends Kid
{
    public $searchString;
    public $group;
    public $ageFrom;
    public $ageTo;
    public $address;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['searchString', 'group', 'address'], 'safe'],
            [['ageFrom', 'ageTo'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'ageFrom' => Yii::t('kid', 'Age (from)'),
            'ageTo' => Yii::t('kid', 'Age (to)'),
            'address' => Yii::t('kid', 'Address'),
        ];
    }

    public function getGroupList()
    {
        return KidGroup::find()
            ->select('name')
            ->orderBy('order')
            ->indexBy('id')
            ->asArray()
            ->column();
    }

    /**
     * Keresés
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Kid::find()->with('kidGroups');

        // add conditions that should always apply here
        if (!Yii::$app->user->can('manageKids')) {
            $query->where(['inactive' => 0]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
            'sort' => [
                'defaultOrder' => ['inactive' => SORT_ASC, 'name' => SORT_ASC]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->orFilterWhere(['like', 'kid.name', $this->searchString])
            ->orFilterWhere(['like', 'kid.family', $this->searchString])
            ->orFilterWhere(['like', 'kid.educator_name', $this->searchString]);

        $query->andFilterWhere(['and',
            ['>=', new \yii\db\Expression('TIMESTAMPDIFF(YEAR, kid.birth_date, CURDATE())'), $this->ageFrom],
            ['<=', new \yii\db\Expression('TIMESTAMPDIFF(YEAR, kid.birth_date, CURDATE())'), $this->ageTo],
            ['like', 'kid.address', $this->address],
        ]);

        if ($this->group) {
            $query->leftJoin(KidGroupKid::tableName(), 'kid_id = kid.id');
            $query->andFilterWhere(['kid_group_id' => $this->group]);
        }

        return $dataProvider;
    }
}
