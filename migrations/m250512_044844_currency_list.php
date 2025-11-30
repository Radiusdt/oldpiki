<?php

use \yii\db\Migration;

/**
* Class m250512_044844_currency_list
*/
class m250512_044844_currency_list extends Migration
{
    public function safeUp()
    {
        foreach ($this->currencyList() as $iso) {
            $data = Yii::$app->db->createCommand('SELECT id FROM currency WHERE iso = :iso', [
                ':iso' => $iso,
            ])->queryScalar();
            if (empty($data)) {
                $this->insert('currency', [
                    'iso' => $iso,
                    'rate' => 0,
                    'is_default' => $iso == 'USD' ? '1' : '0',
                ]);
            }
        }
    }

    public function safeDown()
    {

    }


    private function currencyList()
    {
        return [
            'USD', 'EUR', 'AED', 'AFN', 'ALL', 'AMD', 'AOA', 'ARS', 'AUD',
            'AWG', 'AZN', 'BAM', 'BBD', 'BDT', 'BGN', 'BHD', 'BIF', 'BMD',
            'BND', 'BOB', 'BOV', 'BRL', 'BSD', 'BTN', 'BWP', 'BYN', 'BZD',
            'CAD', 'CDF', 'CHE', 'CHF', 'CHW', 'CLF', 'CLP', 'CNY', 'COP',
            'COU', 'CRC', 'CUP', 'CVE', 'CZK', 'DJF', 'DKK', 'DOP', 'DZD',
            'EGP', 'ERN', 'ETB', 'EUR', 'FJD', 'FKP', 'GBP', 'GEL', 'GHS',
            'GIP', 'GMD', 'GNF', 'GTQ', 'GYD', 'HKD', 'HNL', 'HTG', 'HUF',
            'IDR', 'ILS', 'INR', 'IQD', 'IRR', 'ISK', 'JMD', 'JOD', 'JPY',
            'KES', 'KGS', 'KHR', 'KMF', 'KPW', 'KRW', 'KWD', 'KYD', 'KZT',
            'LAK', 'LBP', 'LKR', 'LRD', 'LSL', 'LYD', 'MAD', 'MDL', 'MGA',
            'MKD', 'MMK', 'MNT', 'MOP', 'MRU', 'MUR', 'MVR', 'MWK', 'MXN',
            'MXV', 'MYR', 'MZN', 'NAD', 'NGN', 'NIO', 'NOK', 'NPR', 'NZD',
            'OMR', 'PAB', 'PEN', 'PGK', 'PHP', 'PKR', 'PLN', 'PYG', 'QAR',
            'RON', 'RSD', 'RUB', 'RWF', 'SAR', 'SBD', 'SCR', 'SDG', 'SEK',
            'SGD', 'SHP', 'SLE', 'SOS', 'SRD', 'SSP', 'STN', 'SVC', 'SYP',
            'SZL', 'THB', 'TJS', 'TMT', 'TND', 'TOP', 'TRY', 'TTD', 'TWD',
            'TZS', 'UAH', 'UGX', 'USD', 'USN', 'UYI', 'UYU', 'UYW', 'UZS',
            'VED', 'VES', 'VND', 'VUV', 'WST', 'XAF', 'XAG', 'XAU', 'XBA',
            'XBB', 'XBC', 'XBD', 'XCD', 'XCG', 'XDR', 'XOF', 'XPD', 'XPF',
            'XPT', 'XSU', 'XTS', 'XUA', 'XXX', 'YER', 'ZAR', 'ZMW', 'ZWG',
        ];
    }
}
