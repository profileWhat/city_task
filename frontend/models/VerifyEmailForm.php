<?php

namespace frontend\models;

use common\models\User;
use Yii;
use yii\base\InvalidArgumentException;
use yii\base\Model;

/**
 * Verify Email Form
 */
class VerifyEmailForm extends Model
{
    public $input_token;

    /**
     * @var User
     */
    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [

            ['input_token', 'trim'],
            ['input_token', 'required'],
            ['input_token', 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'token' => 'Verification Token',
        ];
    }


    /**
     * Creates a form model with given token.
     *
     * @param User $user
     * @param array $config name-value pairs that will be used to initialize the object properties
     */
    public function __construct(User $user, array $config = [])
    {
        $this->_user = $user;
        $token = $user->getVerificationToken();
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('Verify email token cannot be blank.');
        }
        parent::__construct($config);
    }

    /**
     * Verify email
     *
     * @return bool the saved model or null if saving fails
     */
    public function verifyEmail(): bool
    {
        if ($this->_user->validateVerificationToken($this->input_token)) {
            return $this->_user->save(false);
        }
        return false;
    }
}
