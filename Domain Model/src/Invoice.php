<?php
declare(strict_types=1);

namespace harlequiin\Patterns\DomainModel\Entity;

/**
 * Invoice entity represents invoices, has many-to-one
 * relationship with Order entity.
 */
class Invoice extends AbstractEntity
{
    /**
     * @var Order
     */
    protected $order;

    /**
     * @var \DateTime
     */
    protected $invoiceDate;

    /**
     * @var float
     */
    protected $total;

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function setOrder(Order $order): void
    {
        $this->order = $order;
    }

    public function getInvoiceDate(): \DateTime
    {
       return $this->invoiceDate;
    }

    public function setInvoiceDate(\DateTime $invoiceDate): void
    {
        $this->invoiceDate = $invoiceDate;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function setTotal(float $total)
    {
        $this->total = $total;
    }
}
