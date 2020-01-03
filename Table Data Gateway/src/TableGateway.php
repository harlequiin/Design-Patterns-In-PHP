<?php
declare(strict_types=1);

namespace harlequiin\Patterns\TABLEDataGateway;

use PDO;

/**
 * TableGateway.
 *
 * We define basic find and delete methods here that are
 * the same for all gateways.
 */
abstract class TableGateway
{
    /**
     * @var PDO PHP Data Object
     */
    protected $pdo;

    protected const TABLE = "";

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @throws GatewayException
     */
    public function find(int $id): array
    {
        $sql = "SELECT * FROM " . static::TABLE . " WHERE id = ?";
        try {
            $pdoStatement = $this->pdo->prepare($sql);
            $pdoStatement->execute([$id]);
        } catch(\Exception $e) {
            throw new GatewayException($e);
        }

        return $pdoStatement->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * @throws GatewayException
     */
    public function delete(int $id): void
    {
        $sql = "DELETE FROM " . static::TABLE . " WHERE id = ?";
        try {
            $pdoStatement = $this->pdo->prepare($sql);
            $pdoStatement->execute([$id]);
        } catch (\Exception $e) {
            throw new GatewayException($e);
        }
    }

    abstract function insert(): void;
    abstract function update(int $id): void;
}
