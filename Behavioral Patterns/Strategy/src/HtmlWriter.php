<?php
declare(strict_types=1);

namespace harlequiin\Patterns\Strategy;

/**
 * Concrete Strategy.
 *
 * Implements the algorithm behind the  WriterStrategy interface.
 */
class HtmlWriter implements WriterStrategy
{
    public function write(string $data): string
    {
        return "<div>{$data}</div>";
    }
}
