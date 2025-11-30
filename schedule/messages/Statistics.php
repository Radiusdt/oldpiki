<?php
namespace app\schedule\messages;

use app\schedule\components\AbstractMessage;

/**
 * @property-read \app\modules\track\models\Event $event
 * @property-read \app\modules\track\models\Track $track
 */
class Statistics extends AbstractMessage
{
    public $eventId;
    public $eventAttributes;

    public $trackId;
    public $trackAttributes;

    public $action;

    /**
     * @var \app\modules\track\models\Event|null|false
     */
    protected $_event = false;

    /**
     * @var \app\modules\track\models\Track|null|false
     */
    protected $_track = false;

    public function isClick()
    {
        return !empty($this->trackId) || empty($this->eventId);
    }

    public function isEvent()
    {
        return !empty($this->eventId);
    }

    public function getEvent()
    {
        if ($this->_event === false) {
            if (!empty($this->eventAttributes)) {
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

    public function getTrack()
    {
        if ($this->_track === false) {
            if (!empty($this->trackAttributes)) {
                $this->_track = new \app\modules\track\models\Track($this->trackAttributes);
            } else {
                $this->_track = \app\modules\track\models\Track::findById($this->trackId);
            }

            if (empty($this->_track)) {
                $this->_track = null;
            }
        }

        return $this->_track;
    }
}