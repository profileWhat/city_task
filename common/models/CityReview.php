<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%city_review}}".
 *
 * @property int $id
 * @property int $city_id
 * @property int $review_id
 *
 * @property City $city
 * @property Review $review
 */
class CityReview extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%city_review}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_id', 'review_id'], 'required'],
            [['city_id', 'review_id'], 'integer'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['city_id' => 'id']],
            [['review_id'], 'exist', 'skipOnError' => true, 'targetClass' => Review::class, 'targetAttribute' => ['review_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city_id' => 'City ID',
            'review_id' => 'Review ID',
        ];
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

    /**
     * Gets query for [[Review]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReview()
    {
        return $this->hasOne(Review::class, ['id' => 'review_id']);
    }

}
