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

    /**
     * @var int
     */
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

    public function setCustomer(Customer $customer): void
    {
        $this->customer= $customer;
    }

    public function getOrderNumber(): int
    {
       return $this->orderNumber; 
    }

    public function setOrderNumber(int $orderNumber): void
    {
        $this->orderNumber = $orderNumber;
    }

    public function getDescription(): string
    {
       return $this->description; 
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function setTotal(float $total): void
    {
        $this->total = $total;
    }
}
