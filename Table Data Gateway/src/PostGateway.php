<?php
declare(strict_types=1);

namespace harlequiin\Patterns\TableDataGateway;

use PDO;
use Exception;

/**
 * PostGateway.
 *
 * Provides a Table Gateway implementation for Post table.
 */
class PostGateway extends TableGateway
{
    protected const TABLE = "post";

    public function findByUser(int $id): array
    {
        $sql = "SELECT * FROM " . self::TABLE . " WHERE user_id = ?; "; 
        try {
            $pdoStatement = $this->pdo->prepare($sql);
            $pdoStatement->execute([$id]);
            return $pdoStatement->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            throw new GatewayException($e);
        }
    }

    public function insert(string $text = null, int $user_id = null): void
    {
        $sql = "INSERT INTO " . self::TABLE . " VALUES (?, ?);";
        try {
            $this->pdo->prepare($sql)->execute([$text, $user_id]);
        } catch (Exception $e) {
            throw new GatewayException($e);
        }
    }

    public function update(int $id, string $text = null): void
    {
        $sql = "UPDATE " . self::TABLE . " SET text = :text WHERE id = :id ;";
        try {
            $this->pdo->prepare($sql)->execute(["id" => $id, "text" => $text]);
        } catch (Exception $e) {
            throw new GatewayException($e);
        }
    }
}
