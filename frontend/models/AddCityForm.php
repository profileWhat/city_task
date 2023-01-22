<?php

namespace frontend\models;

use common\components\CityAdapter;
use common\exceptions\CityNotFoundException;
use Yii;
use yii\base\Model;

class AddCityForm extends Model
{
    public $cityName;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['cityName', 'required'],
            ['cityName', 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cityName' => 'City Name',
        ];
    }

    /**
     * Add city by city Name with CityAdapter
     */
    public function addCity() {
        if ($this->validate()) {
            try {
                CityAdapter::addCity($this->cityName);
            } catch (CityNotFoundException $e) {
                return false;
            }
        }
        return true;
    }
}