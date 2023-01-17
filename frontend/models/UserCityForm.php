<?php

namespace frontend\models;

use common\models\City;
use Yii;
use yii\base\Model;

class UserCityForm extends Model
{
    private $city_info;

    public function __construct($config = [])
    {
        $this->city_info = Yii::$app->geolocation->getInfo('78.85.49.168');
        parent::__construct($config);
    }

    public function getUserCityName()
    {
        if (isset($this->city_info)) {
            return $this->city_info['geoplugin_city'];
        }
        return null;
    }

    public function getUserCity() {
        if (isset($this->city_info)) {
            return Yii::$app->cityAdapter->getCityByName($this->getUserCityName());
        }
        return null;
    }
}