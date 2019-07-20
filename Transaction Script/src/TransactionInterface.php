<?php
declare(strict_types=1);

namespace harlequiin\Patterns\TransactionScript;

interface TransactionInterface
{
    public function run();
}
