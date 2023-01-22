<?php

namespace common\exceptions;

use Yii;
use yii\base\ExitException;

class ReviewNotFoundException extends ExitException
{
    /**
     * @param string $name
     * @param string $message
     * @param int $code
     * @param int $status
     * @param \Exception $previous
     */
    public function __construct($name, $message = null, $code = 0, $status = 500, \Exception $previous = null)
    {
        # Генерируем ответ
        $view = Yii::$app->getView();
        $response = Yii::$app->getResponse();
        $response->data = $view->renderFile('@common/exceptions/views/reviewNotFoundException.php', [
            'name' => $name,
            'message' => $message,
        ]);

        # Возвратим нужный статус (по-умолчанию отдадим 500-й)
        $response->setStatusCode($status);

        parent::__construct($status, $message, $code, $previous);
    }
}