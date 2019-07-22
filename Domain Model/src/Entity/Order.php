<?php
declare(strict_types=1);

namespace harlequiin\Patterns\DomainModel\Entity;

/**
 * Order entity represents orders. Has many-to-one 
 * relationship with User entity.
 */
class Order extends AbstractEntity
{
    /**
     * @var Customer
     */
    protected $customer;

    protected $orderNumber;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var float
     */
    protected $total;

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): Order
    {
        $this->customer= $customer;
        return $this;
    }

    public function getOrderNumber()
    {
       return $this->orderNumber; 
    }

    public function setOrderNumber($orderNumber): Order
    {
        $this->orderNumber = $orderNumber;
        return $this;
    }

    public function getDescription(): string
    {
       return $this->description; 
    }

    public function setDescription(string $description): Order
    {
        $this->description = $description;
        return $this;
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