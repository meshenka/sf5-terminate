<?php

namespace App\Infrastructure\Metrics\Event;

use Symfony\Contracts\EventDispatcher\Event;

/**
 * The order.placed event is dispatched each time an order is created
 * in the system.
 */
class Ticked extends Event
{
}
