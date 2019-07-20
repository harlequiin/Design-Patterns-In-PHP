<?php
declare(strict_types=1);

namespace harlequiin\Patterns\ActiveRecord;

class MySqlDatabase implements DatabaseInterface
{
    /**
     * @var \PDO database driver
     */
    private $pdo;

    public function __construct(\PDO $pdo)
    {
       $this->pdo = $pdo; 
    }

    /**
     * @throws \PDOException
     */
    public function create(string $table, array $fields): void
    {
        $sql = "INSERT INTO `{$table}`(";

        $keys = \array_keys($fields);

        foreach ($keys as $key) {
            $sql .= "`{$key}`, ";
        }
        $sql = \rtrim($sql, ", ");
        $sql .= ") VALUES (";

        foreach ($keys as $key) {
            $sql .= ":{$key}, ";
        }

        $sql = \rtrim($sql, ", ");
        $sql .= ") ;";

        $stmnt = $this->pdo->prepare($sql);
        $stmnt->execute($fields);

        if (!$stmnt->rowCount()) {
            throw new \PDOException('Creation failed.');
        }
    }

    public function update(string $table, $id, array $fields): void
    {
        $sql = "UPDATE `{$table}` SET ";
        $setValues = "";

        foreach (array_keys($fields) as $key) {
            $setValues .= "`{$key}` = :{$key} AND ";
        }
        $setValues = \rtrim($setValues, "AND ");
        $sql .= $setValues;
        $sql .= " WHERE `id` = {$id} ;";

        $stmnt = $this->pdo->prepare($sql);
        $stmnt->execute($fields);

        if (!$stmnt->rowCount()) {
            throw new \PDOException('Update failed.');
        }
    }

    /**
     * @throws \PDOException
     */
    public function deleteById(string $table, $id): void
    {
        $sql = "DELETE FROM `{$table}` WHERE `id` = :id ;";     

        $stmnt = $this->pdo->prepare($sql);
        $stmnt->execute(["id" => $id]);

        if (!$stmnt->rowCount()) {
            throw new \PDOException("Deletion unsuccessful");
        }
    }

    public function findById(string $table, $id): array
    {
        $sql = "SELECT * FROM `{$table}` WHERE `id` = ? ;";
        $stmnt = $this->pdo->prepare($sql);
        $stmnt->execute([$id]);

        return $stmnt->fetchAll();
    }

    public function findByAttributeValue(string $table, string $attribute, $value): array
    {
        $sql = "SELECT * FROM `{$table}` WHERE {$attribute} = ? ;";        
        $stmnt = $this->pdo->prepare($sql);
        $stmnt->execute([$value]);

        return $stmnt->fetchAll();
    }

    public function findAll(string $table): array
    {
        $sql = "SELECT * FROM `{$table}` ;";
        $stmnt = $this->pdo->query($sql);

        return $stmnt->fetchAll();
    }
}
