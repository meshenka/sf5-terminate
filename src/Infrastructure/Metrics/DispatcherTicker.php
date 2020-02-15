<?php

namespace App\Infrastructure\Metrics;

use App\Domain\Tick\Ticker;
use App\Infrastructure\Metrics\Event\Ticked;
use DateTimeInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class DispatcherTicker implements Ticker
{
    private Ticker $ticker;
    private EventDispatcherInterface $dispatcher;

    public function __construct(Ticker $ticker, EventDispatcherInterface $dispatcher)
    {
        $this->ticker = $ticker;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Just return the system time.
     */
    public function tick(): DateTimeInterface
    {
        $tick = $this->ticker->tick();

        $this->dispatcher->dispatch(new Ticked());

        return $tick;
    }
}
