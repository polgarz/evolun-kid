<?php

namespace evolun\kid\controllers;

use Yii;
use evolun\kid\models\ExtraField;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Kid extra field CRUD
 */
class ExtraFieldController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
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
                        'actions' => ['create', 'update', 'delete', 'index'],
                        'allow' => true,
                        'roles' => ['manageAdminData']
                    ],
                ]
            ],
        ];
    }

    /**
     * Lists all ExtraField model
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ExtraField::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates an ExtraField model
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ExtraField();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('kid', 'Create successful'));
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('danger', Yii::t('kid', 'Create failed'));
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an ExtraField model
     * @param string $id Kid extra field ID
     * @return mixed
     * @throws NotFoundHttpException if the requested field does not exists
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('kid', 'Update successful'));
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('danger', Yii::t('kid', 'Update failed'));
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an ExtraField model
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the requested field does not exists
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Find ExtraField model by id
     * @param integer $id
     * @return ExtraField
     * @throws NotFoundHttpException if the requested field does not exists
     */
    protected function findModel($id)
    {
        if (($model = ExtraField::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
    }
}
