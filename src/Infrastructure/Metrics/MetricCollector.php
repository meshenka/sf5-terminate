<?php

namespace App\Infrastructure\Metrics;

use App\Infrastructure\Metrics\Event\Ticked;
use Psr\Log\LoggerInterface;

/**
 * This is statefull, use with cautions.
 */
class MetricCollector
{
    private LoggerInterface $logger;

    private int $ticks = 0;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function collect(Ticked $event): void
    {
        ++$this->ticks;
    }

    public function release(): void
    {
        $this->logger->info('Ticker call metrics', [
            'count' => $this->ticks,
        ]);

        $this->ticks = 0;
    }
}
