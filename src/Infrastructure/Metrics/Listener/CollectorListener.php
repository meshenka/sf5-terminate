<?php

namespace App\Infrastructure\Metrics\Listener;

use App\Infrastructure\Metrics\Event\Ticked;
use App\Infrastructure\Metrics\MetricCollector;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\TerminateEvent;

class CollectorListener implements EventSubscriberInterface
{
    private MetricCollector $collector;

    public function __construct(MetricCollector $collector)
    {
        $this->collector = $collector;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            Ticked::class => 'onTicked',
            TerminateEvent::class => 'onTerminate',
        ];
    }

    public function onTicked(Ticked $event)
    {
        $this->collector->collect($event);
    }

    public function onTerminate(TerminateEvent $event)
    {
        $this->collector->release();
    }
}
