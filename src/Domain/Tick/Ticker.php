<?php

namespace App\Domain\Tick;

use DateTimeInterface;

interface Ticker
{
    public function tick(): DateTimeInterface;
}
