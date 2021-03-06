<?php
declare(strict_types=1);

namespace harlequiin\Patterns\State;

/**
 * ConcreteState.
 *
 * Extends the base State object (OrderState) and overrides
 * its methods, if necessary.
 */
class OrderPending extends OrderState
{
    /**
     * @var string;
     */
    protected const STATUS = "pending";

    public function prepare(): void
    {
       $this->order->setState(new OrderReady($this->order)); 
    }

    public function cancel(): void
    {
        $this->order->setState(new OrderCancelled($this->order));
    }
}
