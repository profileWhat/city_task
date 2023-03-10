<?php

namespace common\models;

use yii\base\InvalidConfigException;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;
use yii\helpers\Html;

/**
 * This is the model class for table "{{%review}}".
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property int $rating
 * @property string|null $img
 * @property int|null $create_time
 * @property int|null $author_id
 *
 * @property User $author
 * @property City[] $cities
 */
class Review extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%review}}';
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
            ],
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'author_id',
                'updatedByAttribute' => 'author_id',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['title', 'text', 'rating'], 'required'],
            ['img', 'file', 'extensions' => 'png, jpg'],
            ['text', 'string', 'max' => 255],
            [['rating', 'author_id'], 'integer'],
            [['rating'], 'integer', 'min' => 1, 'max' => 5],
            [['title'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'text' => 'Text',
            'rating' => 'Rating',
            'img' => 'Img',
            'create_time' => 'Create Time',
            'author_id' => 'Author ID',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return ActiveQuery
     */
    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getCities(): ActiveQuery
    {
        return $this->hasMany(City::class, ['id' => 'city_id'])
            ->viaTable('{{%city_review}}', ['review_id' => 'id']);
    }

    /**
     * Gets link to author
     *
     * @return string
     */
    public function getAuthorLink(): string
    {
        return Html::a($this->author->fio, $this->author->getUrl());
    }

    /**
     * Gets link to city
     *
     * @return array
     */
    public function getCitiesLink(): array
    {
        $links = [];
        if (count($this->cities) > 0) {
            foreach ($this->cities as $city) {
                $links[] = Html::a($city->name, $city->getUrl());
            }
            return $links;
        }
        $links[] = Html::a('All cities', City::getCitiesUrl());
        return $links;
    }

    /**
     * Set cities to CityReview table
     *
     * @param $cities
     * @return bool
     */
    public function setCities($cities): bool
    {
        CityReview::deleteAll(['review_id' => $this->id]);
        foreach ($cities as $city) {
            $cityReview = new CityReview();
            $cityReview->city_id = $city->id;
            $cityReview->review_id = $this->id;
            if (!$cityReview->save()) return false;
        }
        return true;
    }
}
