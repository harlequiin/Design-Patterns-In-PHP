<?php
declare(strict_types=1);

namespace harlequiin\Patterns\TableDataGateway;

use PDO;
use Exception;

/**
 * User Gateway.
 *
 * Provides a Table Gateway implementation for User table.
 */
class UserGateway extends TableGateway
{
    protected const TABLE = "user";

    public function findByUsername(string $username): array
    {
        $sql = "SELECT * FROM " . self::TABLE . " WHERE username = ?; "; 
        try {
            $pdoStatement = $this->pdo->prepare($sql);
            $pdoStatement->execute([$username]);
            return $pdoStatement->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            throw new GatewayException($e);
        }
    }

    public function insert(string $username = NULL): void
    {
        $sql = "INSERT INTO " . self::TABLE . " VALUES (?);";
        try {
            $this->pdo->prepare($sql)->execute([$username]);
        } catch (Exception $e) {
            throw new GatewayException($e);
        }
    }

    public function update(int $id, string $username = null): void
    {
        $sql = "UPDATE " . self::TABLE . " SET username = :username WHERE id = :id ;";
        try {
            $this->pdo->prepare($sql)->execute(["id" => $id, "username" => $username]);
        } catch (Exception $e) {
            throw new GatewayException($e);
        }
    }
}
