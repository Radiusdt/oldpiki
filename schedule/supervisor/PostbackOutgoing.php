<?php
namespace app\schedule\supervisor;

use app\schedule\components\Supervisor;
use app\schedule\consumers\PostbackOutgoingConsumer;

class PostbackOutgoing extends Supervisor
{
    public $commandClass = PostbackOutgoingConsumer::class;

    public $parallelProcessAmount = 1;

    public $defaultMessageClass = \app\schedule\messages\Event::class;

    public $description = 'Send outgoing postbacks';
}