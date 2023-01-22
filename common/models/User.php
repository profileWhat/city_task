<?php

namespace common\models;

use Yii;
use yii\base\Exception;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;
use yii\helpers\Url;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property string $fio
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property int|null $create_time
 *
 * @property Review[] $reviews
 */
class User extends ActiveRecord implements IdentityInterface
{
    private $verification_token;
    public $auth_key;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['create_time'],
                ],
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['fio', 'email', 'phone', 'password'], 'required'],
            [['fio', 'email', 'password'], 'string', 'max' => 128],
            [['phone'], 'string', 'max' => 20],
            [['phone'], 'match', 'pattern' => '/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/'],
            ['email', 'email'],
            ['email', 'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'fio' => 'Full Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'password' => 'Password',
            'create_time' => 'Create Time',
        ];
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return ActiveQuery
     */
    public function getReviews(): ActiveQuery
    {
        return $this->hasMany(Review::class, ['author_id' => 'id']);
    }

    /**
     * Gets user view URL
     *
     * @return string
     */
    public function getUrl(): string
    {
        return Url::to(['user/view', 'id' => $this->id]);
    }

    public function getReviewsUrl(): string
    {
        return Url::to(['user/reviews', 'id' => $this->id]);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws Exception
     */
    public function setPassword(string $password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @inheritDoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds user by username
     *
     * @param $email
     * @return static|null
     */
    public static function findByEmail($email): ?User
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * Finds user by username
     *
     * @param $email
     * @return static|null
     */
    public static function findByUsername($email): ?User
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * @inheritDoc
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritDoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritDoc
     */
    public function validateAuthKey($authKey): ?bool
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Generates "remember me" authentication key
     * @throws Exception
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new token for email verification
     * @throws Exception
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString();
    }

    /**
     * return email verification token
     * @return mixed
     */
    public function getVerificationToken()
    {
        return $this->verification_token;
    }

    /**
     * validate input verification token
     */
    public function validateVerificationToken($verification_token): bool
    {
        return $this->verification_token == $verification_token;
    }

}
