<?php
namespace app\schedule\components;

class CronConfigBuilder
{
    protected $configs = [];

    public $queueConfigPath = '@app/schedule/cron';

    protected $template;

    const SEPARATOR = "\n";
    const SYMBOL = '#';

    public function create()
    {
        $commands = $this->readSchedule();
        $padding = $this->createPadding($commands);
        $this->appendHeader($padding);
        foreach ($commands as $command) {
            if ($command->isBadConfigured()) {
                continue;
            }
            $this->appendConfig($command, $padding);
        }
        $this->appendFooter($padding);

        return $this->createJobConfig();
    }

    private function appendHeader($padding)
    {
        $titles = [
            'time' => [
                'minute' => 'm',
                'hour' => 'h',
                'dayOfMonth' => 'dom',
                'month' => 'mon',
                'dayOfWeek' => 'dow',
            ],
            'command' => [
                'command' => 'command',
                'description' => 'description',
            ]
        ];

        $this->configs[] = $this->getRowSeparator($padding);

        $row = self::SYMBOL;
        foreach ($titles['time'] as $name => $value) {
            $row .= '  ' . str_pad($value, $padding['time'][$name], ' ', STR_PAD_RIGHT);
        }
        //$row .= self::SYMBOL;
        foreach ($titles['command'] as $name => $value) {
            $row .= ' ' . str_pad($value, $padding['command'][$name], ' ', STR_PAD_RIGHT);
        }
        $this->configs[] = $row;

        $this->configs[] = $this->getRowSeparator($padding);
    }

    private function appendFooter($padding)
    {
        $this->configs[] = $this->getRowSeparator($padding);
    }

    private function getRowSeparator($padding)
    {
        $row = self::SYMBOL;
        foreach ($padding as $group => $values) {
            foreach ($values as $name => $value) {
                $row .= str_pad('', $value, self::SYMBOL, STR_PAD_RIGHT) . self::SYMBOL . self::SYMBOL;
            }
        }
        return $row;
    }

    /**
     * @param Cron[] $crons
     */
    private function createPadding(array $crons)
    {
        $padding = [
            'time' => [
                'minute' => 1,
                'hour' => 1,
                'dayOfMonth' => 3,
                'month' => 3,
                'dayOfWeek' => 3,
            ],
            'command' => [
                'command' => 20,
                'description' => 25,
            ]
        ];
        foreach ($crons as $cron) {
            foreach ($cron->time() as $time) {
                foreach ($padding['time'] as $name => $value) {
                    if ($value < strlen((string)$time->$name)) {
                        $padding['time'][$name] = mb_strlen($time->$name);
                    }
                }
            }
            foreach ($padding['command'] as $name => $value) {
                if ($value < strlen((string)$cron->$name)) {
                    $padding['command'][$name] = mb_strlen($cron->$name);
                }
            }
        }

        foreach ($padding as $group => $values) {
            foreach ($values as $name => $value) {
                $padding[$group][$name] += 2;
            }
        }

        return $padding;
    }

    private function createJobConfig()
    {
        return implode(self::SEPARATOR, $this->configs) . self::SEPARATOR;
    }

    /**
     * @return Cron[]
     */
    private function readSchedule()
    {
        $list = [];
        $directory = dir(\Yii::getAlias($this->queueConfigPath));
        while (false !== ($entry = $directory->read())) {
            if (!in_array($entry, ['.', '..']) && strpos($entry, '.php') !== false && strpos($entry, '~') === false) {
                $className = str_replace(['/', '@'], '\\', $this->queueConfigPath) . '\\' . str_replace('.php', '', $entry);
                $list[] = new $className;
            }
        }
        $directory->close();

        return $list;
    }

    private function appendConfig(Cron $command, $padding)
    {
        foreach ($command->time() as $time) {
            $row = ' ';
            foreach ($padding['time'] as $name => $value) {
                $row .= ' ' . ' ' . str_pad($time->$name, $value, ' ', STR_PAD_RIGHT);
            }
            $row .= ' ' . str_pad($command->getCommand(), $padding['command']['command'], ' ', STR_PAD_RIGHT);
            $row .= ' ' . self::SYMBOL;
            $row .= ' ' . str_pad(strval($command->description), $padding['command']['description'], ' ', STR_PAD_RIGHT);
            $this->configs[] = $row;
        }
    }
}