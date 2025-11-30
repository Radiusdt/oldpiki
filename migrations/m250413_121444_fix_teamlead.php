<?php

use \yii\db\Migration;

/**
* Class m250413_121444_fix_teamlead
*/
class m250413_121444_fix_teamlead extends Migration
{
    public function safeUp()
    {
        /**
         * @var \yii\rbac\DbManager $auth
         */
        $auth = \Yii::$app->get('authManager');

        $user = $auth->getRole(\app\modules\user\enums\Role::USER->value);
        $admin = $auth->getRole(\app\modules\user\enums\Role::ADMINISTRATOR->value);
        $superadmin = $auth->getRole(\app\modules\user\enums\Role::SUPER_ADMIN->value);

        $teamlead = $auth->createRole(\app\modules\user\enums\Role::TEAMLEAD->value);
        $auth->add($teamlead);
        $auth->addChild($teamlead, $user);

        $auth->addChild($admin, $teamlead);
        $auth->addChild($superadmin, $teamlead);
    }

    public function safeDown()
    {
        /**
         * @var \yii\rbac\DbManager $auth
         */
        $auth = \Yii::$app->get('authManager');

        $user = $auth->getRole(\app\modules\user\enums\Role::USER->value);
        $admin = $auth->getRole(\app\modules\user\enums\Role::ADMINISTRATOR->value);
        $teamlead = $auth->getRole(\app\modules\user\enums\Role::TEAMLEAD->value);
        $superadmin = $auth->getRole(\app\modules\user\enums\Role::SUPER_ADMIN->value);

        $auth->removeChild($superadmin, $teamlead);
        $auth->removeChild($admin, $teamlead);
        $auth->removeChild($teamlead, $user);
        $auth->remove($teamlead);
    }
}
