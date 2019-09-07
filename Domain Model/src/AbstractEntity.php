<?php
declare(strict_types=1);

namespace harlequiin\Patterns\DomainModel\Entity;

/**
 * Abstract Entity enforces id for each subclass.
 */
abstract class AbstractEntity
{
    protected $id;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
}
