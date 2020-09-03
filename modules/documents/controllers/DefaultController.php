<?php

namespace evolun\kid\modules\documents\controllers;

use Yii;
use evolun\kid\modules\documents\models\KidDocument;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\helpers\Inflector;

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
        parent::init();

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
                        'actions' => ['index', 'documents', 'download'],
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
        $model = new KidDocument(['kid_id' => $id]);

        return $this->renderPartial('index', [
            'model' => $model,
            'kid' => $this->getKid(),
        ]);
    }

    /**
     * Töröl egy dokumentumot
     * A törlendő kép id-t $_POST-ban várja
     * JSON response
     * @param  int    $id A gyerek id-ja
     * @return array
     */
    public function actionDelete(int $id) : array
    {
        Yii::$app->response->format = 'json';

        $model = KidDocument::findOne(['kid_id' => $id, 'id' => Yii::$app->request->post('document_id')]);

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

        $model = new KidDocument(['kid_id' => $id]);

        // dokumentum feltoltese
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->validate() && $model->save()) {
                return ['success' => 1];
            } else {
                return ['success' => 0, 'error' => $model->getErrorSummary(false)];
            }
        }
    }

    /**
     * Letölt egy dokumentumot
     * @param  int $id A gyerek id-ja
     * @param  int $document_id A dokumentum id-ja
     * @return array
     */
    public function actionDownload($id, $document_id)
    {
        $model = KidDocument::findOne(['kid_id' => $id, 'id' => $document_id]);

        if ($model) {
            return Yii::$app->response->sendFile(
                $model->getUploadPath('file'),
                Inflector::slug($model->name) . '_' . $model->file
            );
        } else {
            throw new NotFoundHttpException('Nem létező dokumentum.');
        }
    }

    /**
     * Visszaadja a gyerekhez tartozó dokumentumokat
     * JSON response
     * @param  int $id A gyerek id-ja
     * @return array
     */
    public function actionDocuments($id) : array
    {
        Yii::$app->response->format = 'json';

        $documents = KidDocument::findAll(['kid_id' => $id]);
        $return = [];

        foreach ($documents as $document) {
            $return[] = [
                'id' => $document->id,
                'name' => $document->name,
                'date' => $document->created_at ? Yii::$app->formatter->asDate($document->created_at) : null,
                'extension' => pathinfo($document->getUploadUrl('file'), PATHINFO_EXTENSION),
                'createdBy' => ($document->createdBy ? $document->createdBy->name : null),
                'url' => Url::to(['download', 'id' => $id, 'document_id' => $document->id]),
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
