<?php
namespace app\components;

use yii\console\ErrorHandler;
use yii\console\Request;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class ErrorHandlerConsole extends ErrorHandler
{
    public function handleException($exception)
    {
        if ((!$exception instanceof NotFoundHttpException) && !($exception instanceof ForbiddenHttpException)) {
            //$location = \Yii::$app->request instanceof Request ? implode(' ', \Yii::$app->request->getParams()) : \Yii::$app->request->url;
        }
        return parent::handleException($exception);
    }
}