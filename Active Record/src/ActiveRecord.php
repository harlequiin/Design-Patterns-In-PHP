<?php
declare (strict_types = 1);

namespace harlequiin\Patterns\ActiveRecord;

use PDO;
use PDOException;
use Exception;

abstract class ActiveRecord
{
    /**
     * @var PDO PHP Data Object
     */
    protected $pdo;

    /**
     * @var string table name
     */
    protected const TABLE = "";

    /**
     * @var int ID of the record
     */
    protected $id;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function insert(): void
    {
        $properties = $this->collectProperties();
        $keys = "";
        $placeholders = "";

        foreach (array_keys($properties) as $key) {
            $keys .= "`{$key}`, ";
            $placeholders .= ":{$key}, ";
        }
        $keys = \rtrim($keys, ", ");
        $placeholders = \rtrim($placeholders, ", ");

        $sql  = "INSERT INTO " . static::TABLE . "(";
        $sql .= $keys;
        $sql .= ") VALUES (";
        $sql .= $placeholders;
        $sql .= ") ;";

        try {
            $stmnt = $this->pdo->prepare($sql);
            $stmnt->execute($properties);

            if (!$stmnt->rowCount()) {
                throw new PDOException('Creation failed.');
            }
        } catch (Exception $e) {
            throw new ActiveRecordException($e->getMessage());
        }
    }

    abstract protected function collectProperties(): array;

    public function update(): void
    {
        $properties = $this->collectProperties();
        $properties["id"] = $this->getId();

        $setValues = "";

        foreach (array_keys($properties) as $key) {
            $setValues .= "`{$key}` = :{$key}, ";
        }
        $setValues = \rtrim($setValues, ", ");
        $sql  = "UPDATE " . static::TABLE . "SET ";
        $sql .= $setValues;
        $sql .= " WHERE `id` = :id;";

        try {
            $stmnt = $this->pdo->prepare($sql);
            $stmnt->execute($properties);

            if (!$stmnt->rowCount()) {
                throw new PDOException('Update failed.');
            }
        } catch (Exception $e) {
            throw new ActiveRecordException($e->getMessage());
        }
    }

    public function delete()
    {
        $sql = "DELETE FROM " . static::TABLE . "WHERE id = :id";
        try {
            $this->pdo->prepare($sql)->execute(["id" => $this->getId()]);
        } catch (Exception $e) {
            throw new ActiveRecordException($e->getMessage());
        }
    }
}
