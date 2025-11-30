<?php
namespace app\commands;
use app\components\CurrencyUpdater;
use app\modules\structure\models\Currency;
use cheatsheet\Time;
use DateTime;
use Exception;
use Exchanger\Exchanger;
use Exchanger\ExchangeRateQueryBuilder;
use Exchanger\Service\OpenExchangeRates;
use Http\Client\Curl\Client as CurlClient;
use yii\console\Controller;

class CurrencyController extends Controller
{
    public function actionUpdate()
    {
        $updater = new CurrencyUpdater();

        foreach (Currency::find()->all() as $currency) {
            /**
             * @var Currency $currency
             */
            $updater->loadAndSave($currency);
        }
    }
}