<?php
namespace app\components;

use yii\console\Request;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class ErrorHandlerWeb extends \yii\web\ErrorHandler
{
    public function handleException($exception)
    {
        if ((!$exception instanceof NotFoundHttpException) && !($exception instanceof ForbiddenHttpException)) {
            //$location = \Yii::$app->request instanceof Request ? implode(' ', \Yii::$app->request->getParams()) : \Yii::$app->request->url;
            //MonitoringReport::sendMessage('[' . str_pad($exception->getCode(), 3, '0', STR_PAD_LEFT) . '] General exception (' . $location . '): ' . $exception->getMessage());
        }
        return parent::handleException($exception);
    }
}