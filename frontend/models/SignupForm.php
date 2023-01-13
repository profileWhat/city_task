<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $fio;
    public $email;
    public $phone;
    public $password;
    public $confirm_password;
    public $verify_code;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            ['fio', 'trim'],
            ['fio', 'required'],
            ['fio', 'string', 'max' => 128],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 128],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['phone', 'trim'],
            ['phone', 'required'],
            ['phone', 'match', 'pattern' => '/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/', 'message' => 'This entered phone number is incorrect'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            ['confirm_password', 'required'],
            ['confirm_password', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match"],

            ['verify_code', 'required'],
            ['verify_code', 'captcha'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'fio' => 'Full Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'password' => 'Password',
            'confirm_password' => 'Confirm Password',
            'verifyCode' => 'Verification code',
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup($user)
    {
        if (!$this->validate()) {
            return null;
        }

        $user->email = $this->email;
        $user->fio = $this->fio;
        $user->phone = $this->phone;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();

        return $this->sendEmail($user);
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
