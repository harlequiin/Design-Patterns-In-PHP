<?php
declare(strict_types=1);

namespace harlequiin\Patterns\DomainModel\Entity;

/**
 * Customer entity represents customers in system.
 */
class Customer extends AbstractEntity
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $email;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Customer
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail(): string
    {
       return $this->email; 
    }

    public function setEmail(string $email): Customer
    {
        $this->email = $email;
        return $this;
    }
}
