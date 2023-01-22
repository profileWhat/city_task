<?php

namespace frontend\controllers;

use common\exceptions\ReviewNotFoundException;
use common\models\Review;
use frontend\models\ReviewForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

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
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['view'],
                            'allow' => true,
                            'roles' => ['?'],
                        ],
                        [
                            'actions' => ['index', 'view', 'create', 'update', 'delete'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
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
    public function actionIndex(): string
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Review::find()->where(['author_id' => Yii::$app->user->id]),
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
     * @return string|Response
     */
    public function actionView(int $id)
    {
        try {
            $model = $this->findModel($id);
        } catch (ReviewNotFoundException $e) {
            return $this->redirect('index');
        }
        return $this->render('view', [
            'model' => $model
        ]);
    }

    /**
     * Creates a new Review model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * If request is Ajax, action will return created review view
     *
     * @return string|Response
     */
    public function actionCreate()
    {
        $model = new ReviewForm();
        if ($this->request->isAjax) {
            if ($this->request->isPost && $model->load($this->request->post())) {
                $model->img = UploadedFile::getInstance($model, 'img');
                if ($model->uploadImg() && $model->saveReview()) {
                    return $this->renderAjax('@frontend/views/review/view.php', [
                        'model' => $model->getReview(),
                    ]);
                }
            }
            return $this->renderAjax('@frontend/views/review/create.php', [
                'model' => $model,
            ]);
        }
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->img = UploadedFile::getInstance($model, 'img');
                if ($model->uploadImg() && $model->saveReview()) {
                    return $this->redirect(['index']);
                }
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
     *
     * @param int $id ID
     * @return string|Response
     * @throws ReviewNotFoundException if the model cannot be found
     */
    public function actionUpdate(int $id)
    {
        $model = new ReviewForm();
        $model->loadDefaultValues($this->findModel($id));

        if ($this->request->isAjax) {
            if ($this->request->isPost && $model->load($this->request->post())) {

                $model->img = UploadedFile::getInstance($model, 'img');

                if ($model->uploadImg() && $model->saveReview()) {
                    return $this->renderAjax('@frontend/views/review/view.php', [
                        'model' => $this->findModel($id),
                    ]);
                }
            }
            return $this->renderAjax('@frontend/views/review/update.php', [
                'model' => $model,
            ]);
        }

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->img = UploadedFile::getInstance($model, 'img');
            if ($model->uploadImg() && $model->saveReview()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Review model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * if request is Ajax, action will be return result of deletion
     *
     * @param int $id ID
     * @return false|int|Response
     * @throws \Throwable
     */
    public function actionDelete(int $id)
    {
        try {
            $result = $this->findModel($id)->delete();
        } catch (ReviewNotFoundException | StaleObjectException $e) {
            return $this->redirect(['index']);
        }

        if ($this->request->isAjax) return $result;
        return $this->redirect(['index']);
    }

    /**
     * Finds the Review model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id ID
     * @return Review the loaded model
     * @throws ReviewNotFoundException if the model cannot be found
     */
    protected function findModel($id): Review
    {
        if (($model = Review::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new ReviewNotFoundException("Review not found.", "Review with that id is not found");
    }
}
