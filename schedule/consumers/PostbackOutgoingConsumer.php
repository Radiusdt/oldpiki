<?php
namespace app\schedule\consumers;

use app\modules\track\components\Source;
use app\schedule\messages\Event;
use GuzzleHttp\Client;

class PostbackOutgoingConsumer extends AbstractConsumer
{
    /**
     * @var Event $data
     */
    public function process($data)
    {
        $integration = $data->getEvent()->campaign?->source?->getIntegration();
        if (!empty($integration)) {
            $this->sendPostback($integration, $data->event);
        }
    }

    private function sendPostback(Source $integration, \app\modules\track\models\Event $event)
    {
        $integration->postback($event);
    }
}