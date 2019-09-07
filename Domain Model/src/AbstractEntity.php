<?php
declare(strict_types=1);

namespace harlequiin\Patterns\DomainModel\Entity;

/**
 * Abstract Entity enforces id for each subclass.
 */
abstract class AbstractEntity
{
    /**
     * @var int
     */
    protected $id;

    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
