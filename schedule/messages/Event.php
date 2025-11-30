<?php
namespace app\schedule\messages;

use app\schedule\components\AbstractMessage;

/**
 * @property-read \app\modules\track\models\Event $event
 */
class Event extends AbstractMessage
{
    public $eventId;
    public $eventAttributes;

    /**
     * @var \app\modules\track\models\Event|null|false
     */
    protected $_event = false;

    public function getEvent()
    {
        if ($this->_event === false) {
            if (!empty($this->eventAttributes) && !empty($this->eventAttributes['event_id'])) {
                $this->_event = new \app\modules\track\models\Event($this->eventAttributes);
            } else {
                $this->_event = \app\modules\track\models\Event::findById($this->eventId);
            }

            if (empty($this->_event)) {
                $this->_event = null;
            }
        }

        return $this->_event;
    }
}