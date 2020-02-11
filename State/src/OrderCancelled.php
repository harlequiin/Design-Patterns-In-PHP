<?php
declare(strict_types=1);

namespace harlequiin\Patterns\State;

/**
 * ConcreteState.
 *
 * Extends the base State object (OrderState) and overrides
 * its methods, if necessary.
 */
class OrderCancelled extends OrderState
{
    /**
     * @var string;
     */
    protected const STATUS = "cancelled";
}

