<?php
namespace app\schedule\components;

class SupervisorConfigBuilder
{
    protected $configs = [];
    protected $groups = [];

    public $queueConfigPath = '@app/schedule/supervisor';

    protected $template;

    const SEPARATOR = "\r\n\r\n";

    const CONFIG_TEMPLATE = <<<TEXT
[program:{PROCESS_NAME}]
autostart = true
autorestart = true
command = php {DIR}/yii {COMMAND}
stdout_logfile = {DIR}/runtime/logs/{LOG_FILE}.supervisor.log
stderr_logfile = {DIR}/runtime/logs/{LOG_FILE}.supervisor.error.log
startretries = 3
user = {PHP_USER}
TEXT;

    public function create()
    {
        $commands = $this->readSchedule();
        foreach ($commands as $command) {
            if ($command->isBadConfigured() || $command->parallelProcessAmount <= 0) {
                continue;
            }
            for ($number = 0; $number < $command->parallelProcessAmount; $number++) {
                $this->appendConfig($command, $number);
            }
        }
        return $this->createGroupConfig() . self::SEPARATOR . $this->createJobConfig();
    }

    private function createGroupConfig()
    {
        $config = [];
        foreach ($this->groups as $groupName => $processNames) {
            $processes = implode(',', $processNames);
            $config[] = <<<CONFIG
[group: {$groupName}]
programs={$processes}
CONFIG;
        }

        return implode(self::SEPARATOR, $config);
    }

    private function createJobConfig()
    {
        return implode(self::SEPARATOR, $this->configs);
    }

    /**
     * @return Supervisor[]
     */
    public function readSchedule()
    {
        $list = [];
        $directory = dir(\Yii::getAlias($this->queueConfigPath));
        while (false !== ($entry = $directory->read())) {
            if (!in_array($entry, ['.', '..']) && strpos($entry, '.php') !== false && strpos($entry, '~') === false) {
                $className = trim(str_replace(['/', '@'], '\\', $this->queueConfigPath) . '\\' . str_replace('.php', '', $entry));
                /**
                 * @var Supervisor $command
                 */
                $command = new $className;
                $list[$command->getArguments()] = $command;
            }
        }
        $directory->close();

        return $list;
    }

    private function createConfigParams(Supervisor $command, $number = 1)
    {
        return [
            '{PROCESS_NAME}' => $command->getLogFileName($number),
            '{DIR}' => realpath(__DIR__ . '/../../'),
            '{COMMAND}' => $command->getCommandText(),
            '{LOG_FILE}' => $command->getLogFileName($number),
            '{PHP_USER}' => $command->runAsSuperuser ? 'root' : \Yii::$app->params['phpUser'],
        ];
    }

    private function appendConfig(Supervisor $command, $number = 1)
    {
        $params = $this->createConfigParams($command, $number);
        $this->configs[] = str_replace(array_keys($params), array_values($params), self::CONFIG_TEMPLATE);

        if (empty($this->groups[$command->groupName])) {
            $this->groups[$command->groupName] = [];
        }
        $this->groups[$command->groupName][] = $params['{PROCESS_NAME}'];
    }

    public function getCommandList()
    {
        $list = [];
        foreach ($this->readSchedule() as $command) {
            $list[] = $command->getCommandText() . ' 1';
        }
        return $list;
    }
}