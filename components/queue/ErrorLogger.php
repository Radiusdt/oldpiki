<?php

namespace app\components\queue;

use Bernard\Envelope;
use Bernard\Event\RejectEnvelopeEvent;
use Exception;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Throwable;

class ErrorLogger implements EventSubscriberInterface
{
    const DELIMITER = "-------------------------------------------------------------------------------------------------------------------------------";

    public function onReject(RejectEnvelopeEvent $event)
    {
        error_log($this->format($event->getEnvelope(), $event->getException()));
    }

    /**
     * @param Envelope $envelope
     * @param mixed    $exception
     *
     * @return string
     */
    protected function format(Envelope $envelope, $exception)
    {
        if ($exception instanceof Exception || $exception instanceof Throwable) {
            $message = '[{date}][bernard] caught exception {class}::{message} while processing {envelope}. ';
            return strtr(PHP_EOL . self::DELIMITER . PHP_EOL . $message . PHP_EOL . PHP_EOL . 'Stack trace: ' . PHP_EOL . '{trace}', [
                '{class}' => get_class($exception),
                '{message}' => $exception->getMessage(),
                '{envelope}' => $envelope->getName(),
                '{trace}' => $exception->getTraceAsString(),
                '{date}' => date('Y-m-d H:i:s'),
            ]);
        }

        $message = '[{date}][bernard] caught unknown error type {type} while processing {envelope}. ';
        return strtr(PHP_EOL . self::DELIMITER . PHP_EOL . $message . PHP_EOL . PHP_EOL . 'Stack trace: ' . PHP_EOL . '{trace}', [
            '{type}' => is_object($exception) ? get_class($exception) : gettype($exception),
            '{envelope}' => $envelope->getName(),
            '{trace}' => $exception->getTraceAsString() ?? '',
            '{date}' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'bernard.reject' => ['onReject'],
        ];
    }
}