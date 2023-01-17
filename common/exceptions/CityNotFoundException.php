<?php
namespace common\exceptions;

use Yii;
use yii\base\ExitException;

class CityNotFoundException extends \RuntimeException
{

    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}