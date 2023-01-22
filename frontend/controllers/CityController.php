<?php

namespace frontend\controllers;

use common\models\City;
use common\models\CitySearch;
use frontend\models\AddCityForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * CityController implements the CRUD actions for City model.
 */
class CityController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['index', 'view'],
                            'allow' => true,
                            'roles' => ['?'],
                        ],
                        [
                            'actions' => ['index', 'view', 'add-city'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all City models.
     *
     * @param null $isUserCity
     * @return string
     */
    public function actionIndex($isUserCity = null): string
    {
        $searchModel = new CitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single City model.
     * @param int $id ID
     * @return string|Response
     */
    public function actionView(int $id, $isUserCity = false)
    {
        try {
            $model = $this->findModel($id);
        } catch (NotFoundHttpException $e) {
            return $this->redirect('index');
        }
        if ($isUserCity) {
            Yii::$app->session->set('userCity', $model->name);
        }
        return $this->render('view', [
            'model' => $model
        ]);
    }

    /**
     * Add city with City to DB
     * @return string
     */
    public function actionAddCity(): string
    {
        $model = new AddCityForm();

        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->addCity()) {
                Yii::$app->session->setFlash("success", "Your city added");
            } else {
                Yii::$app->session->setFlash("danger", "this city does not exist");
            }
        }

        return $this->render('addCity', [
            'model' => $model
        ]);
    }

    /**
     * Finds the City model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return City the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): City
    {
        if (($model = City::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
