<?php

namespace frontend\controllers;

use common\models\User;
use frontend\models\UserCityForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\captcha\CaptchaAction;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\LoginForm;
use frontend\models\SignupForm;
use yii\web\ErrorAction;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
            'captcha' => [
                'class' => CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @param null $isUserCity
     * @return string
     */
    public function actionIndex($isUserCity = null): string
    {
        $userCityForm = new UserCityForm();


        return $this->render('index', [
            'userCityModel' => $userCityForm
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return Response
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout(): string
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return Response|string
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        $user = new User();
        if ($model->load(Yii::$app->request->post()) && $model->signup($user)) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            Yii::$app->session->set('user', $user);
            return $this->redirect(['verify-email']);
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Verify user email to sign it up.
     *
     * @return Response|string
     */
    public function actionVerifyEmail()
    {
        $user = Yii::$app->session->get('user');
        if (empty($user)) {
            return $this->redirect(['signup']);
        }
        $model = new VerifyEmailForm($user);
        if ($model->load(Yii::$app->request->post())) {
            if (($model->verifyEmail()) && Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            } else Yii::$app->session->setFlash('error', 'Incorrect verification token');
        }

        return $this->render('verifyEmail', [
            'model' => $model
        ]);
    }
}
