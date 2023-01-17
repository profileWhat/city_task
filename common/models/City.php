<?php

namespace common\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%city}}".
 *
 * @property int $id
 * @property string $name
 * @property int|null $create_time
 *
 * @property Review[] $reviews
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%city}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['create_time'], 'integer'],
            [['name'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'create_time' => 'Create Time',
        ];
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['id' => 'review_id'])
            ->viaTable('{{%city_review}}', ['city_id' => 'id']);
    }

    /**
     * Gets city view URL
     *
     * @return string
     */
    public function getUrl()
    {
        return Url::to(['city/view', 'id' => $this->id]);
    }

    public static function getCitiesUrl()
    {
        return Url::to(['city/index']);
    }
}
