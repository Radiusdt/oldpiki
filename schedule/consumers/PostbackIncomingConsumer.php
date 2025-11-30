<?php
namespace app\schedule\consumers;

use app\components\queue\Bernard;
use app\modules\structure\enums\PayoutType;
use app\modules\structure\models\Currency;
use app\modules\track\models\Event;
use app\modules\track\models\Track;
use app\schedule\messages\Postback;
use app\schedule\messages\Statistics;

class PostbackIncomingConsumer extends AbstractConsumer
{
    /**
     * @var Postback $data
     */
    public function process($data)
    {
        $event = $this->createEvent($data);
        $this->storeStatistics($event);
        $this->storePostback($event);
    }

    private function storePostback(Event $event)
    {
        Bernard::produce((new \app\schedule\supervisor\PostbackOutgoing())->queueName(), new \app\schedule\messages\Event([
            'eventId' => $event->getFullEventId(),
            'eventAttributes' => $event->attributes,
        ]));
    }

    private function storeStatistics(Event $event)
    {
        Bernard::produce((new \app\schedule\supervisor\StatisticsEvent())->queueName(), new Statistics([
            'trackId' => $event->getFullTrackId(),
            'trackAttributes' => $event->track->attributes,
            'eventId' => $event->getFullEventId(),
            'eventAttributes' => $event->attributes,
        ]));
    }

    private function createEvent(Postback $postback)
    {
        $track = $this->findTrack($postback);
        $event = new Event();
        $event->unixtimestamp = time();
        $event->initiate();
        $event->event_date = date('Y-m-d');
        $event->event_data = json_encode($postback->params);
        $event->event = $this->convertEventName($postback->event_name)->value;
        $event->setAttribute('subids.param', array_keys($postback->params));
        $event->setAttribute('subids.value', array_values($postback->params));
        if (!empty($track)) {
            $event->track_id = $track->track_id;
            $event->track_time = $track->unixtimestamp;
            $event->track_date = $track->event_date;
            $event->campaign_id = $track->campaign_id;
            $event->offer_id = $track->offer_id;
            $event->source_id = $track->source_id;
        }
        if (!empty($event->offer)) {
            if ($event->offer->payment_event_name == $event->event) {
                $event->payment_in_amount = $event->offer->payment_amount;
            }
            if (!empty($postback->params['payout'])) {
                $event->payment_in_amount = $postback->params['payout'];
            }
            $event->payment_in_currency_id = $event->offer->payment_currency_id;
            if (!empty($postback->params['currency'])) {
                $event->payment_in_currency_id = Currency::getIdByIso($postback->params['currency']);
            }
        }

        if (!empty($event->campaign)) {
            $event->user_id = $event->campaign->user_id;
            if ($event->campaign->payout_type == PayoutType::PERCENT->value) {
                $event->payment_out_amount = $event->campaign->payout_amount / 100 * $event->payment_in_amount;
            } elseif ($event->event == $event->campaign->payout_event_name) {
                $event->payment_out_amount = $event->campaign->payout_amount;
            }
            $event->payment_out_currency_id = $event->campaign->payout_currency_id;
            if (empty($event->payment_out_currency_id)) {
                $event->payment_out_currency_id = $event->payment_in_currency_id;
            }
        }

        $event->payment_in_amount_usd = Currency::getCurrency($event->payment_in_currency_id)?->convertToUsd($event->payment_in_amount);
        $event->payment_out_amount_usd = Currency::getCurrency($event->payment_out_currency_id)?->convertToUsd($event->payment_out_amount);
        $event->payment_revenue_amount = $event->payment_in_amount - $event->payment_out_amount;
        $event->payment_revenue_amount_usd = $event->payment_in_amount_usd - $event->payment_out_amount_usd;

        $event->save(false);

        return $event;
    }

    private function findTrack(Postback $postback)
    {
        return Track::findById($postback->track_id);
    }

    private function convertEventName($eventName)
    {
        static $mapping = [
            'install' => [
                'af_app_install', 'af_first_launch', 'install',
                'first_install', 'app_installed', '', null
            ],

            'reg' => [
                'af_complete_registration', 'sign_up', 'registration_success',
                'user_register', 'account_created', 'registration',
            ],

            'deposit' => [
                'af_purchase', 'deposit',
                'payment_success', 'add_funds', 'transaction_completed',
            ],

            'first_deposit' => [
                'first_purchase_in_digital', 'first_deposit',
            ],

            'recurring_deposit' => [
                'recurring_deposit',
            ],

            'sub' => [
                'subscription_start', 'premium_subscribed', 'trial_activated',
                'pro_membership', 'renew_subscription'
            ],
            'open' => [
                'af_app_opened', 'app_launch', 'session_start', 'app_open'
            ]
        ];

        foreach ($mapping as $unifiedEvent => $events) {
            if (in_array($eventName, $events, true)) {
                return \app\modules\track\enums\Event::tryFrom($unifiedEvent);
            }
        }

        return \app\modules\track\enums\Event::UNDEFINED;
    }
}