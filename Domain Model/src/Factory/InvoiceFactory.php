<?php
declare(strict_types=1);

namespace harlequiin\Patterns\DomainModel\Factory;

use harlequiin\Patterns\DomainModel\Entity\Order;
use harlequiin\Patterns\DomainModel\Entity\Invoice;

/**
 * Factory for invoice entities.
 */
class InvoiceFactory
{
    public function createFromOrder(Order $order)
    {
        $invoice = new Invoice();
        $invoice->setOrder($order);
        $invoice->setTotal($order->getTotal());
        $invoice->setInvoiceDate(new \DateTime());

        return $invoice;
    }
}
