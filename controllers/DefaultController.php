<?php

namespace evolun\kid\controllers;

use Yii;
use evolun\kid\models\KidForm;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use evolun\kid\modules\KidSubModule;

/**
 * DefaultController implements the CRUD actions for Kid model.
 */
class DefaultController extends Controller
{
    /**
     * {@inheritdoc}
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
                        'actions' => ['create', 'update', 'delete'],
                        'allow'   => true,
                        'roles'   => ['manageKids'],
                        'roleParams' => function ($rule) {
                            $kidModel = $this->module->kidModelClass;
                            $kid = $kidModel::findOne(Yii::$app->request->get('id'));

                            if ($kid) {
                                return ['kid' => $kid];
                            }
                        }
                    ],
                    [
                        'actions' => ['index', 'view'],
                        'allow'   => true,
                        'roles'   => ['showKids'],
                    ],
                ]
            ],
        ];
    }

    /**
     * Kilistázza a gyerekeket
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = Yii::createObject($this->module->kidSearchModelClass);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Egy gyerek adatlapja
     * @param integer $id A gyerek id-ja
     * @return mixed
     * @throws NotFoundHttpException ha nem létező gyerek id-t kap
     */
    public function actionView($id)
    {
        $modules = [];
        $model = $this->findModel($id);

        if ($this->module->modules) {
            foreach ($this->module->modules as $id => $module) {
                $module = $this->module->getModule($id);

                if (!$module instanceof KidSubModule) {
                    continue;
                }

                if (count($module->allowedGroupIds)
                    && !array_intersect($module->allowedGroupIds, ArrayHelper::getColumn($model->kidGroupKids, 'kid_group_id'))) {
                    continue;
                }

                $modules[] = [
                    'title' => $module->title ?? 'Modul',
                    'content' => $module->runAction($module->defaultRoute, Yii::$app->request->get())
                ];
            }
        }

        return $this->render('view', [
            'model' => $model,
            'modules' => $modules,
        ]);
    }

    /**
     * Gyerek felvétele, ha sikeres, az adatlapra ugrik
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new KidForm();
        $userList = $this->getUserList();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('kid', 'Create successful'));
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('danger', Yii::t('kid', 'Create unsuccessful'));
            }
        }

        return $this->render('create', [
            'model' => $model,
            'userList' => $userList,
        ]);
    }

    /**
     * Gyerek adatlapjának módosítása, ha sikeres, az adatlapra ugrik
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException ha nem létező gyerek id-t kap
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $userList = $this->getUserList();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('kid', 'Update successful'));
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('danger', Yii::t('kid', 'Update unsuccessful'));
            }
        }

        return $this->render('update', [
            'model' => $model,
            'userList' => $userList,
        ]);
    }

    /**
     * Töröl egy gyerek modelt, ha sikeres, a listára ugrik
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException ha nem létező gyerek id-t kap
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Visszaadja a felhasznalok listajat
     * @return array
     */
    protected function getUserList()
    {
        $userModel = Yii::$app->user->identityClass;

        return $userModel::find()
            ->select('name')
            ->indexBy('id')
            ->orderBy('name')
            ->asArray()
            ->column();
    }

    /**
     * Megkeres egy gyerek modelt
     * @param integer $id
     * @return KidForm
     * @throws NotFoundHttpException ha nem létező gyerek id-t kap
     */
    protected function findModel($id)
    {
        if (($model = KidForm::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
    }
}
