<?php
namespace app\components;

use app\modules\structure\models\Currency;
use DateTime;
use Exchanger\Exception\UnsupportedExchangeQueryException;
use Exchanger\Exchanger;
use Exchanger\ExchangeRateQueryBuilder;
use Exchanger\Service\OpenExchangeRates;
use Http\Client\Curl\Client as CurlClient;

class CurrencyUpdater
{
    /**
     * @var Exchanger
     */
    private $exchanger = null;

    public function __construct()
    {
        $client = new CurlClient();

        $service = new OpenExchangeRates($client, null, [
            'app_id' => \Yii::$app->params['openexchangeRatesKey'],
        ]);

        $this->exchanger = new Exchanger($service);
    }

    public function loadAndSave(Currency $currency)
    {
        if ($currency->iso == 'USD') {
            $currency->rate = 1;
            $currency->save(false);
            return;
        }

        $currency->rate = 1 / $this->loadRate($currency);
        $currency->save(false);
    }

    private function loadRate(Currency $currency)
    {
        try {
            $query = (new ExchangeRateQueryBuilder('USD/' . $currency->iso));
            //$query = $query->setDate(new DateTime());
            $query = $query->build();

            $response = $this->exchanger->getExchangeRate($query);

            return 1 / $response->getValue();
        } catch (UnsupportedExchangeQueryException $exception) {
            return 0;
        }
    }
}