<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\BaseActiveRecord;

/**
 * This is the model class for table "{{%review}}".
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property int $rating
 * @property resource|null $img
 * @property int|null $create_time
 * @property int|null $city_id
 * @property int|null $author_id
 *
 * @property User $author
 * @property City $city
 */
class Review extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%review}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['create_time'],
                ],
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => ['author_id', 'city_id'],
                'updatedByAttribute' => ['author_id', 'city_id'],
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'text', 'rating', 'author_id'], 'required'],
            [['text', 'img'], 'string'],
            [['rating', 'city_id', 'author_id'], 'integer'],
            [['rating', 'min' => 1, 'max' => 5]],
            [['title'], 'string', 'max' => 128],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'text' => 'Text',
            'rating' => 'Rating',
            'img' => 'Img',
            'create_time' => 'Create Time',
            'city_id' => 'City ID',
            'author_id' => 'Author ID',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }
}
