<?php
declare(strict_types=1);

namespace harlequiin\Patterns\TableDataGateway;

use PDO;

class UserGateway extends TableGateway
{
    protected const TABLE = "user";

    public function findByUsername(string $username): array
    {
        $sql = "SELECT * FROM " . self::TABLE . " WHERE username = ?; "; 
        try {
            $pdoStatement = $this->pdo->prepare($sql);
            $pdoStatement->execute([$username]);
        } catch (\Exception $e) {
            throw new GatewayException($e);
        }

        return $pdoStatement->fetchAll(PDO::FETCH_OBJ);
    }

    public function insert(string $username = NULL): void
    {
        $sql = "INSERT INTO " . self::TABLE . " VALUES (?);";
        try {
            $this->pdo->prepare($sql)->execute([$username]);
        } catch (\Exception $e) {
            throw new GatewayException($e);
        }
    }

    public function update(int $id, string $username = null): void
    {
        $sql = "UPDATE " . self::TABLE . " SET username = :username WHERE id = :id ;";
        try {
            $this->pdo->prepare($sql)->execute(["id" => $id, "username" => $username]);
        } catch (\Exception $e) {
            throw new GatewayException($e);
        }
    }
}
