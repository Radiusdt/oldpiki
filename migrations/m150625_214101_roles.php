<?php

use app\modules\user\enums\Role;
use yii\db\Migration;

class m150625_214101_roles extends Migration
{
    public function up()
    {
        $auth = \Yii::$app->get('authManager');
        $auth->removeAll();

        $user = $auth->createRole(Role::USER->value);
        $auth->add($user);

        $admin = $auth->createRole(Role::ADMINISTRATOR->value);
        $auth->add($admin);
        $auth->addChild($admin, $user);

        $superadmin = $auth->createRole(Role::SUPER_ADMIN->value);
        $auth->add($superadmin);
        $auth->addChild($superadmin, $user);
        $auth->addChild($superadmin, $admin);
    }

    public function down()
    {
        $auth = \Yii::$app->get('authManager');
        $auth->remove($auth->getRole(Role::SUPER_ADMIN->value));
        $auth->remove($auth->getRole(Role::ADMINISTRATOR->value));
        $auth->remove($auth->getRole(Role::USER->value));
    }
}
