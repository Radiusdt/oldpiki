<?php
namespace app\schedule\supervisor;

use app\schedule\components\Supervisor;

class PostbackIncoming extends Supervisor
{
    public $commandClass = \app\schedule\consumers\PostbackIncomingConsumer::class;

    public $parallelProcessAmount = 1;

    public $defaultMessageClass = \app\schedule\messages\Postback::class;

    public $description = 'Processing incoming postbacks';
}