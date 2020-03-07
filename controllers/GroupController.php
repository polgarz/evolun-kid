<?php

namespace evolun\kid\controllers;

use Yii;
use evolun\kid\models\KidGroup;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Kid group CRUD
 */
class GroupController extends Controller
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
     * Lists all KidGroup model
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => KidGroup::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a KidGroup model
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new KidGroup();

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
     * Updates a KidGroup model
     * @param string $id Kid group ID
     * @return mixed
     * @throws NotFoundHttpException if the requested group does not exists
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
     * Deletes a KidGroup model
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the requested group does not exists
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Find KidGroup model by id
     * @param integer $id
     * @return KidGroup
     * @throws NotFoundHttpException if the requested group does not exists
     */
    protected function findModel($id)
    {
        if (($model = KidGroup::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
    }
}
