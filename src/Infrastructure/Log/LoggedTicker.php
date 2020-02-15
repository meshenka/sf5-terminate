<?php

namespace App\Infrastructure\Log;

use App\Domain\Tick\Ticker;
use DateTimeInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Stopwatch\Stopwatch;

class LoggedTicker implements Ticker
{
    private Ticker $ticker;
    private LoggerInterface $logger;

    public function __construct(Ticker $ticker, LoggerInterface $logger)
    {
        $this->ticker = $ticker;
        $this->logger = $logger;
    }

    /**
     * Just return the system time.
     */
    public function tick(): DateTimeInterface
    {
        $stopwatch = new Stopwatch();
        $stopwatch->start('ticker.tick');
        $tick = $this->ticker->tick();
        $event = $stopwatch->stop('ticker.tick');

        $this->logger->info('Ticker call duration', [
            'duration' => $event->getDuration(),
            'memory' => $event->getMemory(),
        ]);

        return $tick;
    }
}
