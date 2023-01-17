<?php

namespace common\components;

use common\exceptions\CityNotFoundException;
use common\models\City;
use Yii;
use yii\base\Component;

class CityAdapter extends Component
{
    /**
     * Gets city by name
     *
     * @return \common\models\City
     */
    public function getCityByName($name)
    {
        $city = City::findOne(['name' => $name]);
        if (!isset($city)) {
            try {
                $city = self::addCity($name);
            } catch (CityNotFoundException $e) {
                return null;
            }
        }
        return $city;
    }

    /**
     * Add city with unknown name
     *
     * @return \common\models\City
     * @throws CityNotFoundException
     */
    public static function addCity($name)
    {
        $city_info = Yii::$app->citySearch->getInfo($name);
        $city = new City();
        if ($city_info['status'] == 200) {
            $city->name = $name;
            $city->save();
            return City::findOne(['name' => $name]);
        }
        throw new CityNotFoundException('The specified city does not exist');
    }
}