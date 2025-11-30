<?php
namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class LogController extends Controller
{
    public function beforeAction($action)
    {
        \Yii::$app->httpBasicAuth->verify();

        return parent::beforeAction($action);
    }

    public function actionIncoming()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => \app\models\Lead::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'event_date' => SORT_DESC,
                    'unixtimestamp' => SORT_DESC,
                ],
            ],
        ]);
        return $this->render('incoming', ['dataProvider' => $dataProvider]);
    }

    public function actionOutgoing()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => \app\models\Postback::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'event_date' => SORT_DESC,
                    'unixtimestamp' => SORT_DESC,
                ],
            ],
        ]);
        return $this->render('outgoing', ['dataProvider' => $dataProvider]);
    }
}