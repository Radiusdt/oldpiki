<?php

use \yii\db\Migration;

/**
* Class m250512_065052_source_integration
*/
class m250512_065052_source_integration extends Migration
{
    public function safeUp()
    {
        $this->insert('source', [
            'name' => 'XiaomiAds',
            'internal_name' => 'XiaomiAds',
            'detect_by_param' => 'ext',
            'status' => \app\modules\structure\enums\Status::ACTIVE->value,
        ]);
    }

    public function safeDown()
    {
        $this->delete('source', ['internal_name' => 'XiaomiAds']);
    }
}
