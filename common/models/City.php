<?php

namespace common\models;

use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
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
class City extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%city}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
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
    public function attributeLabels(): array
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
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getReviews(): ActiveQuery
    {
        return $this->hasMany(Review::class, ['id' => 'review_id'])
            ->viaTable('{{%city_review}}', ['city_id' => 'id']);
    }

    /**
     * Gets city view URL
     *
     * @return string
     */
    public function getUrl(): string
    {
        return Url::to(['city/view', 'id' => $this->id]);
    }

    /**
     * Gets cities URL
     *
     * @return string
     */
    public static function getCitiesUrl(): string
    {
        return Url::to(['city/index']);
    }
}
