<?php

namespace common\components;

use yii\base\Component;

class GeoCitySearch extends Component
{
    private static $plugin_url;
    private static $api_key;

    public array $config = ['plugin_url' => NULL, 'api_key' => NULL];

    public function __construct($config = [])
    {
        if (isset($config['config']['plugin_url'])) {
            self::$plugin_url = $config['config']['plugin_url'];
        }
        if (isset($config['config']['api_key'])) {
            self::$api_key = $config['config']['api_key'];
        }
        parent::__construct($config);
    }

    private static function createUrl($cityName)
    {
        $urlTmp = preg_replace('!\{\{(cityName)\}\}!', $cityName, self::$plugin_url);
        return preg_replace('!\{\{(api_key)\}\}!', self::$api_key, $urlTmp);
    }

    public static function getInfo($cityName)
    {
        if (!isset(self::$plugin_url)) return null;

        $url = self::createUrl($cityName);

        return json_decode(file_get_contents($url), true);
    }
}