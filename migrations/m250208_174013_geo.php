<?php

use \yii\db\Migration;

/**
* Class m250208_174013_geo
*/
class m250208_174013_geo extends Migration
{
    public function safeUp()
    {
        $this->createTable('geo_country', [
            'id' => $this->primaryKey()->unsigned(),
            'iso' => $this->string(2),
            'name_ru' => $this->string(100),
            'name_en' => $this->string(100),
        ]);
        $this->createIndex('iso', 'geo_country', 'iso');

        $this->createTable('geo_region', [
            'id' => $this->primaryKey()->unsigned(),
            'country_id' => $this->integer()->unsigned(),
            'name_ru' => $this->string(200),
            'name_en' => $this->string(200),
        ]);
        $this->createIndex('country_id', 'geo_region', 'country_id');

        $this->createTable('geo_city', [
            'id' => $this->primaryKey()->unsigned(),
            'country_id' => $this->integer()->unsigned(),
            'region_id' => $this->integer()->unsigned(),
            'name_ru' => $this->string(200),
            'name_en' => $this->string(200),
        ]);
        $this->createIndex('country_id', 'geo_city', 'country_id');
        $this->createIndex('region_id', 'geo_city', 'region_id');


        $this->createTable('internet_service_provider', [
            'id' => $this->primaryKey()->unsigned(),
            'isp' => $this->string(),
            'mcc' => $this->integer(),
            'mnc' => $this->string(10),
            'country_id' => $this->integer(),
            'country_iso' => $this->string(),
            'mobile_brand' => $this->string(128),
            'mobile_operator_id' => $this->integer(),
            'domain' => $this->string(),
            'is_mobile' => $this->boolean()->notNull()->defaultValue(0),
        ]);

        $this->createIndex('country_iso', 'internet_service_provider', 'country_iso');
        $this->createIndex('isp', 'internet_service_provider', 'isp');
        $this->createIndex('country_id', 'internet_service_provider', 'country_id');
        $this->createIndex('is_mobile', 'internet_service_provider', 'is_mobile');
        $this->createIndex('isp_unique', 'internet_service_provider', ['country_id', 'isp', 'mobile_brand'], true);

        $this->createTable('mobile_operator', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128),
            'country_id' => $this->integer(),
            'country_iso' => $this->string(2),
        ]);

        $this->createIndex('uniq', 'mobile_operator', ['name', 'country_iso'], true);
    }

    public function safeDown()
    {
        $this->dropTable('geo_city');
        $this->dropTable('geo_region');
        $this->dropTable('geo_country');

        $this->dropTable('mobile_operator');
        $this->dropTable('internet_service_provider');
    }
}
