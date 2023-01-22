<?php

namespace frontend\controllers;

use common\models\User;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors(): array
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['view', 'reviews'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Displays a single User model.
     *
     * @param int $id ID
     * @return string|Response
     */
    public function actionView(int $id)
    {
        try {
            $model = $this->findModel($id);
        } catch (NotFoundHttpException $e) {
            return $this->redirect('site/index');
        }
        return $this->render('view', [
            'model' => $model
        ]);
    }

    /**
     * Displays user's reviews.
     * @param int $id ID
     * @return string|Response
     */
    public function actionReviews(int $id)
    {
        try {
            $model = $this->findModel($id);
        } catch (NotFoundHttpException $e) {
            return $this->redirect('site/index');
        }

        return $this->render('reviews', [
            'model' => $model
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id ID
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): User
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
