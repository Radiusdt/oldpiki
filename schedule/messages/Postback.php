<?php
namespace app\schedule\messages;

use app\schedule\components\AbstractMessage;

class Postback extends AbstractMessage
{
    public $params;
    public $event_name;
    public $track_id;
}