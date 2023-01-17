<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\BaseActiveRecord;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%review}}".
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property int $rating
 * @property resource|null $img
 * @property int|null $create_time
 * @property int|null $author_id
 *
 * @property User $author
 * @property City[] $cities
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
            ['img', 'string'],
            ['text', 'string', 'max' => 255],
            [['rating', 'city_id', 'author_id'], 'integer'],
            [['rating'], 'integer', 'min' => 1, 'max' => 5],
            [['title'], 'string', 'max' => 100],
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
     * @throws \yii\base\InvalidConfigException
     */
    public function getCities()
    {
        return $this->hasMany(City::class, ['id' => 'city_id'])
            ->viaTable('{{%city_review}}', ['review_id' => 'id']);
    }

    /**
     * Gets link to author
     *
     * @return string
     */
    public function getAuthorLink()
    {
        return Html::a($this->author->fio, $this->author->getUrl());
    }

    /**
     * Gets link to city
     *
     * @return array
     */
    public function getCitiesLink()
    {
        $links = [];
        if (count($this->cities) > 0) {
            foreach($this->cities as $city) {
                $links[] = Html::a($city->name, $city->getUrl());
            }
            return $links;
        }
        $links[] = Html::a('All cities', City::getCitiesUrl());
        return $links;
    }
}
