<?php
namespace app\commands;

class MigrateController extends \yii\console\controllers\MigrateController
{
    public function actionCut($migrations)
    {
        if (strpos($migrations, 'migrations/') === false) {
            $migrations = explode("\r", $migrations);
        } else {
            preg_match_all('/migrations\/([\d\w_\-]+).php/', $migrations, $match);
            $migrations = $match[1];
        }
        foreach ($migrations as $migration) {
            $migration = trim($migration);
            if (!empty($migration)) {
                $this->migrateDown($migration);
            }
        }
    }

    public function actionCreateCh($name)
    {
        $this->templateFile = '@app/components/migrations/templates/clickhouse_migration.php';

        return parent::actionCreate($name);
    }

    public function actionCreate($name)
    {
        $this->templateFile = '@app/components/migrations/templates/migration.php';

        return parent::actionCreate($name);
    }
}