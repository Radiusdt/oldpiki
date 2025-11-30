<?php
namespace app\commands;

use app\modules\track\components\GeoDetect;
use app\modules\track\models\geo\Country;
use app\modules\track\models\geo\Region;
use app\modules\track\models\geo\City;
use app\modules\track\models\geo\InternetServiceProvider;
use app\modules\track\models\geo\MobileOperator;
use GeoIp2\Database\Reader;
use yii\console\Controller;
use Yii;
use yii\helpers\ArrayHelper;

class GeoController extends Controller
{
    const SOURCE_PATH = '@app/data/geo';
    const SOURCE_NAME_COUNTRIES = 'country.tsv';
    const SOURCE_NAME_REGIONS = 'region.tsv';
    const SOURCE_NAME_CITIES = 'city.tsv';

    const BULK_INSERT_ROWS_AMOUNT = 500;
    const READ_MAX_LENGTH = 1000;

    public function actionLoad()
    {
        $this->loadCountries();
        $this->loadRegions();
        $this->loadCities();
    }

    public function loadCountries()
    {
        $handler = fopen(Yii::getAlias(self::SOURCE_PATH) . DIRECTORY_SEPARATOR . self::SOURCE_NAME_COUNTRIES, "r");

        $insertList = [];
        while (($data = fgetcsv($handler, self::READ_MAX_LENGTH, "\t")) !== false) {
            if (count($insertList) >= self::BULK_INSERT_ROWS_AMOUNT) {
                $this->saveRows(Country::tableName(), $insertList);
                $insertList = [];
            }
            $insertList[] = [
                'id' => $data[0],
                'iso' => $data[1],
                'name_ru' => $data[3],
                'name_en' => $data[4],
            ];
        }
        $this->saveRows(Country::tableName(), $insertList);
        fclose($handler);
    }

    public function loadRegions()
    {
        /**
         * @var Country[] $countries
         */
        $countries = Country::find()->indexBy('iso')->all();

        $handler = fopen(Yii::getAlias(self::SOURCE_PATH) . DIRECTORY_SEPARATOR . self::SOURCE_NAME_REGIONS, "r");

        $insertList = [];
        while (($data = fgetcsv($handler, self::READ_MAX_LENGTH, "\t")) !== false) {
            if (!isset($countries[$data[2]])) {
                continue;
            }

            if (count($insertList) >= self::BULK_INSERT_ROWS_AMOUNT) {
                $this->saveRows(Region::tableName(), $insertList);
                $insertList = [];
            }
            $insertList[] = [
                'id' => $data[0],
                'name_ru' => $data[3],
                'name_en' => $data[4],
                'country_id' => $countries[$data[2]]->id
            ];
        }
        $this->saveRows(Region::tableName(), $insertList);
        fclose($handler);
    }

    public function loadCities()
    {
        /**
         * @var Region[] $regions
         */
        $regions = Region::find()->indexBy('id')->all();

        $handler = fopen(Yii::getAlias(self::SOURCE_PATH) . DIRECTORY_SEPARATOR . self::SOURCE_NAME_CITIES, "r");

        $insertList = [];
        while (($data = fgetcsv($handler, self::READ_MAX_LENGTH, "\t")) !== false) {
            if (!isset($regions[$data[1]])) {
                continue;
            }

            if (count($insertList) >= self::BULK_INSERT_ROWS_AMOUNT) {
                $this->saveRows(City::tableName(), $insertList);
                $insertList = [];
            }
            $insertList[] = [
                'id' => $data[0],
                'name_ru' => $data[2],
                'name_en' => $data[3],
                'region_id' => $data[1],
                'country_id' => $regions[$data[1]]->country_id,
            ];
        }
        $this->saveRows(City::tableName(), $insertList);
        fclose($handler);
    }

    public function actionTest($ip)
    {
        $detector = (new GeoDetect($ip, true))->detect();
        echo 'COUNTRY: ', $detector->geo_country_id, "\r\n";
        echo 'OPERATOR: ', $detector->geo_operator_id, "\r\n";
    }

    public function actionIsp()
    {
        $files = [
            Yii::getAlias('@app/data/geo/IP2Location/IP-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ISP-DOMAIN-MOBILE.CSV'),
            Yii::getAlias('@app/data/geo/IP2Location/IPV6-COUNTRY-REGION-CITY-LATITUDE-LONGITUDE-ISP-DOMAIN-MOBILE.CSV'),
        ];
        /**
         *
        "16779264","16781311","CN","China","Guangdong","Guangzhou","23.116670","113.250000","ChinaNet Guangdong Province Network","chinatelecom.com.cn","460","03/11","China Telecom"
        "16781312","16785407","JP","Japan","Tokyo","Tokyo","35.689506","139.691700","I2TS Inc.","i2ts.com","-","-","-"
        "16785408","16793599","CN","China","Guangdong","Guangzhou","23.116670","113.250000","ChinaNet Guangdong Province Network","chinatelecom.com.cn","460","03/11","China Telecom"
         */
        foreach ($files as $fileName) {
            $this->oldLine = '';
            echo $fileName, "\r\n";
            echo 'File check', "\r\n";
            $file = fopen($fileName, 'r');

            $lineAmount = 0;
            $handle = fopen($fileName, "r");
            while(!feof($handle)){
                $line = fgets($handle);
                $lineAmount++;
            }
            fclose($handle);
            echo 'Lines: ', $lineAmount, "\r\n";

            $countries = ArrayHelper::map(Country::find()->all(), 'iso', 'id');
            $lineNumber = 0;
            echo 'File read', "\r\n";
            $insertLines = [];
            while (($line = fgetcsv($file)) !== false) {
                $countryIso = $line[2];
                if (!isset($countries[$countryIso])) {
                    continue;
                }

                $insertLines[] = [
                    'isp' => $line[8],
                    'country_id' => $countries[$countryIso],
                    'country_iso' => $countryIso,
                    'domain' => $line[9],
                    'mcc' => $line[10] == '-' ? null : $line[10],
                    'mnc' => substr($line[11], 0, 10),
                    'mobile_brand' => $line[12],
                    'is_mobile' => !empty($line[12]) && ($line[12] != '-'),
                ];

                $this->drawProgress(round($lineNumber++ / $lineAmount * 100 * 2));
                if (count($insertLines) >= 1000) {
                    $this->insert($insertLines);
                    $insertLines = [];
                }
            }
            fclose($file);
            echo " ready\r\n";
        }

        Yii::$app->db->createCommand(<<<SQL
INSERT IGNORE 
INTO `mobile_operator` (`name`, `country_id`, `country_iso`, `mcc`, `mnc`) 
SELECT `mobile_brand`, `country_id`, `country_iso` , `mcc`, `mnc`
FROM `internet_service_provider` 
WHERE `is_mobile` = 1
SQL
        )->execute();

        Yii::$app->db->createCommand(<<<SQL
UPDATE `internet_service_provider` 
INNER JOIN `mobile_operator` ON (`mobile_operator`.`name` = `internet_service_provider`.`mobile_brand` AND `mobile_operator`.`country_iso` = `internet_service_provider`.`country_iso`) 
SET `internet_service_provider`.`mobile_operator_id` = `mobile_operator`.`id`
WHERE `internet_service_provider`.`is_mobile` = 1
SQL
        )->execute();
    }

    private function insert($lines)
    {
        $sql = Yii::$app->db->createCommand()->batchInsert(InternetServiceProvider::tableName(), array_keys($lines[0]), $lines)->getRawSql();
        $fields = [];
        foreach (array_keys($lines[0]) as $field) {
            $fields[] = '`' . $field . '` = VALUES(`' . $field . '`)';
        }
        Yii::$app->db->createCommand($sql . ' ON DUPLICATE KEY UPDATE ' . implode(', ', $fields))->execute();
    }

    private $oldLine = '';

    private function drawProgress($percent)
    {
        $str = '';
        $str .= '[';
        for ($i = 1; $i <= 100; $i++) {
            if ($percent >= $i) {
                $str .= "█";
            } else {
                $str .= ' ';
            }
        }
        $str .= ']';

        if ($this->oldLine != $str) {
            if (!empty($this->oldLine)) {
                for ($i = 0; $i <= 101; $i++) {
                    echo chr(8);
                }
            }
            echo $str;
            $this->oldLine = $str;
        }
    }

    private function saveRows($tableName, $data)
    {
        if (empty($data)) {
            return;
        }

        $sql = 'INSERT INTO {TABLE_NAME} {FIELD_NAMES} VALUES {VALUE_LIST} ON DUPLICATE KEY UPDATE {UPDATE_LIST}';
        $params = [
            '{TABLE_NAME}' => Yii::$app->db->quoteTableName($tableName),
        ];

        $firstRow = array_values($data)[0];
        $fieldNames = [];
        $duplicateList = [];
        foreach (array_keys($firstRow) as $fieldName) {
            $fieldName = Yii::$app->db->quoteColumnName($fieldName);
            $fieldNames[] = $fieldName;
            $duplicateList[] = $fieldName . ' = VALUES(' . $fieldName . ')';
        }
        $params['{FIELD_NAMES}'] = '(' . implode(', ', $fieldNames) . ')';
        $params['{UPDATE_LIST}'] = implode(', ', $duplicateList);

        $valuesPlaceholders = [];
        $valuesParams = [];
        foreach ($data as $id => $row) {
            $rowValue = [];
            foreach ($row as $field => $value) {
                $rowValue[':' . $field . '_' . $id] = $value;
                $valuesParams[':' . $field . '_' . $id] = $value;
            }
            $valuesPlaceholders[] = implode(', ', array_keys($rowValue));
        }
        $params['{VALUE_LIST}'] = '(' . implode('), (', $valuesPlaceholders) . ')';

        $command = Yii::$app->db->createCommand(str_replace(array_keys($params), array_values($params), $sql))->bindValues($valuesParams);

        if ($amountInsert = $command->execute()) {
            echo 'Inserted ' . $amountInsert . '/' . count($data) . ' rows in ' . $tableName . "\r\n";
        } else {
            echo 'No updates for ' . count($data) . ' rows in ' . $tableName . "\r\n";
        }
    }
}
