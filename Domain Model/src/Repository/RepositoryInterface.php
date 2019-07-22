<?php
declare(strict_types=1);

namespace harlequiin\Patterns\DomainModel\Repository;

/**
 * Base repository interface for all entity repositories.
 */
interface RepositoryInterface
{
    public function getById($id);
    public function getAll();
    public function persist($entity);
    public function begin();
    public function commit();
}
