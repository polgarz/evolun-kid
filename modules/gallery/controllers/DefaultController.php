<?php

namespace evolun\kid\modules\gallery\controllers;

use Yii;
use evolun\kid\modules\gallery\models\KidImage;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

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
                        'actions' => ['upload', 'delete', 'rotate'],
                        'allow'   => true,
                        'roles'   => ['manageKids'],
                        'roleParams' => function ($rule) {
                            return ['kid' => $this->getKid()];
                        }
                    ],
                    [
                        'actions' => ['index', 'images'],
                        'allow'   => true,
                        'roles'   => ['showKids'],
                    ],
                ]
            ],
        ];
    }

    /**
     * Rendereli a galériát
     * @param  int $id A gyerek id-ja
     * @return string
     */
    public function actionIndex(int $id) : string
    {
        return $this->renderPartial('index', [
            'kid' => $this->getKid(),
        ]);
    }

    /**
     * Töröl egy képet
     * A törlendő kép id-t $_POST-ban várja
     * JSON response
     * @param  int    $id A gyerek id-ja
     * @return array
     */
    public function actionDelete(int $id) : array
    {
        Yii::$app->response->format = 'json';

        $model = KidImage::findOne(['kid_id' => $id, 'id' => Yii::$app->request->post('image_id')]);

        if ($model && $model->delete()) {
            return ['success' => 1];
        } else {
            return ['success' => 0];
        }
    }

    /**
     * Menti a kapott képet
     * JSON response
     * @param  int $id A gyerek id-ja
     * @return array
     */
    public function actionUpload($id) : array
    {
        Yii::$app->response->format = 'json';

        $model = new KidImage(['kid_id' => $id]);

        // kep feltoltese
        if (Yii::$app->request->isPost) {
            $model->image = UploadedFile::getInstance($model, 'image');
            if ($model->validate() && $model->save()) {
                return ['success' => 1];
            } else {
                return ['success' => 0];
            }
        }
    }

    /**
     * Forgat egy képet
     * JSON response
     * @param  int $id A gyerek id-ja
     * @return array
     */
    public function actionRotate($id) : array
    {
        Yii::$app->response->format = 'json';

        $model = KidImage::findOne(['kid_id' => $id, 'id' => Yii::$app->request->post('image_id')]);

        if ($model && $model->rotateImage(Yii::$app->request->post('degree'))) {
            return ['success' => 1];
        } else {
            return ['success' => 0];
        }
    }

    /**
     * Visszaadja a gyerekhez tartozó képeket
     * JSON response
     * @param  int $id A gyerek id-ja
     * @return array
     */
    public function actionImages($id) : array
    {
        Yii::$app->response->format = 'json';

        $images = KidImage::findAll(['kid_id' => $id]);
        $return = [];

        foreach ($images as $image) {
            $return[] = [
                'id' => $image->id,
                'imageUrl' => $image->getUploadUrl('image') . '?' . time(),
                'thumbnailUrl' => $image->getThumbUploadUrl('image', 's') . '?' . time(),
            ];
        }

        return $return;
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
