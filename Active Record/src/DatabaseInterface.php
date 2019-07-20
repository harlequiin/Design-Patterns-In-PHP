<?php
declare(strict_types=1);

namespace harlequiin\Patterns\ActiveRecord;

/**
 * Interface for database layer implementations. Made with the thought
 * of relational databases, however, it (probably) can be used for other types
 */
interface DatabaseInterface
{
    public function create(string $table, array $fields): void;
    public function update(string $table, $id, array $fields): void;
    public function deleteById(string $table, $id): void;
    public function findById(string $table, $id): array;
    public function findByAttributeValue(string $table, string $attribute, $value): array;
    public function findAll(string $table): array;
}
