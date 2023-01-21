<?php

namespace frontend\controllers;

use common\models\Review;
use frontend\models\ReviewForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReviewController implements the CRUD actions for Review model.
 */
class ReviewController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Review models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Review::find(),
            'pagination' => [
                'pageSize' => 5
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Review model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Review model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * If request is Ajax, action will return created review view
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ReviewForm();
        if ($this->request->isAjax) {
            if ($this->request->isPost && $model->load($this->request->post()) && $model->saveReview()) {
                return $this->renderAjax('@frontend/views/review/view.php', [
                    'model' => $model->getReview(),
                ]);
            }
            return $this->renderAjax('@frontend/views/review/create.php', [
                'model' => $model,
            ]);
        }
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->saveReview()) {
                return $this->renderAjax('@frontend/views/review/view.php', [
                    'model' => $model->getReview(),
                ]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Review model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * If request is Ajax, action will return updated review view
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = new ReviewForm();
        $model->loadDefaultValues($this->findModel($id));
        if ($this->request->isAjax) {
            if ($this->request->isPost && $model->load($this->request->post()) && $model->saveReview()) {
                return $this->renderAjax('@frontend/views/review/view.php', [
                    'model' => $this->findModel($id),
                ]);
            }
            return $this->renderAjax('@frontend/views/review/update.php', [
                'model' => $model,
            ]);
        }

        if ($this->request->isPost && $model->load($this->request->post()) && $model->saveReview()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Review model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return false|int|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $result = $this->findModel($id)->delete();
        if ($this->request->isAjax) return $result;
        return $this->redirect(['index']);
    }

    /**
     * Finds the Review model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Review the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Review::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
