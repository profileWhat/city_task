<?php

namespace common\models;

use Yii;

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
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fio', 'email', 'phone', 'password'], 'required'],
            [['create_time'], 'integer'],
            [['fio', 'email', 'password'], 'string', 'max' => 128],
            [['phone'], 'string', 'max' => 20],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'Fio',
            'email' => 'Email',
            'phone' => 'Phone',
            'password' => 'Password',
            'create_time' => 'Create Time',
        ];
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['author_id' => 'id']);
    }
}
