<?php
declare(strict_types=1);

namespace harlequiin\Patterns\DomainModel\Repository;

interface OrderRepositoryInterface extends RepositoryInterface
{
    public function getUninvoicedOrders();
}
