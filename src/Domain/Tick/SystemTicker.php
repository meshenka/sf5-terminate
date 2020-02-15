<?php

namespace App\Domain\Tick;

use DateTimeImmutable;
use DateTimeInterface;

class SystemTicker implements Ticker
{
    /**
     * Just return the system time.
     */
    public function tick(): DateTimeInterface
    {
        return new DateTimeImmutable();
    }
}
