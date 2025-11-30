<?php
namespace app\schedule\consumers;

use app\modules\track\enums\Event;
use app\modules\track\models\Track;
use app\schedule\messages\Statistics;

class StatisticsConsumer extends AbstractConsumer
{
    /**
     * @var Statistics $data
     */
    public function process($data)
    {
         if ($data->isEvent()) {
             $this->storeEvent($data);
         } else {
             $this->storeClick($data);
         }
    }

    protected function storeEvent(Statistics $message)
    {
        $statistics = new \app\modules\track\models\Statistics();
        $this->fillStatistics($statistics, $message->event->track);
        $statistics->data_amount_event = 1;
        $statistics->unixtimestamp = $message->event->unixtimestamp;
        switch ($message->event->event) {
            case Event::INSTALL->value:
                $statistics->data_amount_install = 1;
                break;
            case Event::REG->value:
                $statistics->data_amount_reg = 1;
                break;
            case Event::DEPOSIT->value:
                $statistics->data_amount_deposit = 1;
                break;
            case Event::FIRST_DEPOSIT->value:
                $statistics->data_amount_deposit = 1;
                $statistics->data_amount_first_deposit = 1;
                break;
            case Event::RECURRING_DEPOSIT->value:
                $statistics->data_amount_deposit = 1;
                $statistics->data_amount_recurring_deposit = 1;
                break;
            case Event::SUB->value:
                $statistics->data_amount_sub = 1;
                break;
            case Event::OPEN->value:
                $statistics->data_amount_open = 1;
                break;
        }
        $this->fillStatisticsCosts($statistics, $message->event);
        $statistics->save(false);
    }

    protected function storeClick(Statistics $message)
    {
        $statistics = new \app\modules\track\models\Statistics();
        $this->fillStatistics($statistics, $message->track);
        $statistics->data_amount_click = 1;


        $statistics->save(false);
    }

    private function fillStatistics(\app\modules\track\models\Statistics $statistics, Track $track)
    {
        $statistics->setAttributes([
            'unixtimestamp' => time(),
            'track_id' => $track->track_id,
            'track_date' => $track->event_date,
            'track_time' => $track->unixtimestamp,
            'user_id' => $track->user_id,
            'offer_id' => $track->offer_id,
            'source_id' => $track->source_id,
            'campaign_id' => $track->campaign_id,
            'advertiser_id' => $track->advertiser_id,
            'geo_country_id' => $track->geo_country_id,
            'geo_region_id' => $track->geo_region_id,
            'geo_city_id' => $track->geo_city_id,
            'geo_operator_id' => $track->geo_operator_id,
            'user_ip' => $track->user_ip,
            'user_ip_integer' => $track->user_ip_integer,
            'user_device_id' => $track->user_device_id,
            'user_os_id' => $track->user_os_id,
            'user_browser_id' => $track->user_browser_id,
            'subids.param' => $track->getAttribute('subids.param'),
            'subids.value' => $track->getAttribute('subids.value'),
        ], false);
    }

    private function fillStatisticsCosts(\app\modules\track\models\Statistics $statistics, \app\modules\track\models\Event $event)
    {

        $statistics->setAttributes([
            'payment_in_amount' => $event->payment_in_amount,
            'payment_in_amount_usd' => $event->payment_in_amount_usd,
            'payment_in_currency_id' => $event->payment_in_currency_id,
            'payment_out_amount' => $event->payment_out_amount,
            'payment_out_amount_usd' => $event->payment_out_amount_usd,
            'payment_out_currency_id' => $event->payment_out_currency_id,
            'payment_revenue_amount' => $event->payment_revenue_amount,
            'payment_revenue_amount_usd' => $event->payment_revenue_amount_usd,
        ], false);
    }
}