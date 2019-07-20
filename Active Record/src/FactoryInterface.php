<?php
declare(strict_types=1);

namespace harlequiin\Patterns\ActiveRecord;

use harlequiin\Patterns\ActiveRecord\ActiveRecord;

interface FactoryInterface
{
    public function create(): ActiveRecord;
    public function find($id): ActiveRecord;
    /**
     * @return ActiveRecord[]
     */
    public function findAll(): array;
}
