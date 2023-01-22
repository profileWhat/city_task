<?php

namespace frontend\models;

use common\models\City;
use Yii;
use yii\base\Model;

class UserCityForm extends Model
{
    private $city_info;

    /**
     * load geolocation info
     *
     * {@inheritdoc}
     */
    public function __construct($config = [])
    {
        $this->city_info = Yii::$app->geolocation->getInfo('78.85.49.168');
        parent::__construct($config);
    }

    /**
     * Get user city by name
     *
     * @return mixed|null
     */
    public function getUserCityName()
    {
        if (isset($this->city_info)) {
            return $this->city_info['geoplugin_city'];
        }
        return null;
    }

    /**
     * Get user city
     *
     * @return mixed|null
     */
    public function getUserCity()
    {
        if (isset($this->city_info)) {
            return Yii::$app->cityAdapter->getCityByName($this->getUserCityName());
        }
        return null;
    }
}