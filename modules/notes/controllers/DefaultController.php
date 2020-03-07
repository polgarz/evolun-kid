<?php

namespace evolun\kid\modules\notes\controllers;

use Yii;
use evolun\kid\modules\notes\models\KidNote;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;

class DefaultController extends Controller
{
    /**
     * A gyerek modelje
     * @var Kid
     */
    private $_kid;

    /**
     * {@inheritdoc}
     */
    public function init() : void
    {
        $this->setKid($this->module->getKid());
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors() : array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create', 'delete'],
                        'allow'   => true,
                        'roles'   => ['manageKids'],
                        'roleParams' => function ($rule) {
                            return ['kid' => $this->getKid()];
                        }
                    ],
                    [
                        'actions' => ['index', 'notes'],
                        'allow'   => true,
                        'roles'   => ['showKids'],
                    ],
                ]
            ],
        ];
    }

    /**
     * Rendereli a jegyzeteket
     * @param  int $id A gyerek id-ja
     * @return string
     */
    public function actionIndex(int $id) : string
    {
        $model = new KidNote(['kid_id' => $id]);

        return $this->renderPartial('index', [
            'model' => $model,
            'kid' => $this->getKid(),
        ]);
    }

    /**
     * Töröl egy jegyzetet
     * A törlendő jegyzet id-t $_POST-ban várja
     * JSON response
     * @param  int    $id A gyerek id-ja
     * @return array
     */
    public function actionDelete(int $id) : array
    {
        Yii::$app->response->format = 'json';

        $model = KidNote::findOne(['kid_id' => $id, 'id' => Yii::$app->request->post('note_id')]);

        if ($model && $model->delete()) {
            return ['success' => 1];
        } else {
            return ['success' => 0];
        }
    }

    /**
     * Létrehoz egy bejegyzést
     * JSON response
     * @param  int $id A gyerek id-ja
     * @return array
     */
    public function actionCreate($id) : array
    {
        Yii::$app->response->format = 'json';

        $model = new KidNote(['kid_id' => $id]);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate() && $model->save()) {
                return ['success' => 1];
            } else {
                return ['success' => 0, 'error' => $model->getErrorSummary(false)];
            }
        }
    }

    /**
     * Visszaadja a gyerekhez tartozó jegyzeteket
     * JSON response
     * @param  int $id A gyerek id-ja
     * @param  int $page Oldal
     * @return array
     */
    public function actionNotes($id, $page = 0)
    {
        Yii::$app->response->format = 'json';

        $dataProvider = new ActiveDataProvider([
            'query' => KidNote::find()->where(['kid_id' => $id]),
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC]
            ],
            'pagination' => [
                'defaultPageSize' => 5
            ]
        ]);

        return [
            'items' => $dataProvider->models,
            'pagination' => [
                'pageCount' => $dataProvider->pagination->getPageCount()
            ],
        ];
    }

    private function setKid($kid)
    {
        $this->_kid = $kid;
    }

    private function getKid()
    {
        return $this->_kid;
    }
}
