<?php
declare(strict_types=1);

namespace harlequiin\Patterns\RowDataGateway;

use harlequiin\Patterns\RowDataGateway\UserGateway;
use PDO;
use Exception;

/**
 * UserFinder.
 *
 * Finder class for UserGateways. Splitting out finder
 * functionality improves the testability of our classes.
 */
class UserFinder
{
    /**
     * @var PDO PHP Data Object
     */
    private $pdo;

    /**
     * @var string table name
     */
    private const TABLE = "user";
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo; 
    }

    public function find(int $id): UserGateway
    {
        $sql = "SELECT * FROM " . self::TABLE . " WHERE `id` = :id); ";

        try {
            $pdoStatement = $this->pdo->prepare($sql);
            $pdoStatement->execute([
                "id" => $id
            ]);

            $pdoObject = $pdoStatement->fetch(PDO::FETCH_OBJ);

            $gateway = new UserGateway($this->pdo);
            $gateway->setId($pdoObject->id);
            $gateway->setUsername($pdoObject->username);
            $gateway->setAge($pdoObject->age);

            return $gateway;

        } catch (Exception $e) {
            throw new GatewayException($e->getMessage());
        }
    }

    public function findByUsername(string $username): UserGateway
    {
        $sql = "SELECT * FROM " . self::TABLE . " WHERE `username` = :username); ";

        try {
            $pdoStatement = $this->pdo->prepare($sql);
            $pdoStatement->execute([
                "username" => $username
            ]);

            $pdoObject = $pdoStatement->fetch(PDO::FETCH_OBJ);

            $gateway = new UserGateway($this->pdo);
            $gateway->setId($pdoObject->id);
            $gateway->setUsername($pdoObject->username);
            $gateway->setAge($pdoObject->age);

            return $gateway;

        } catch (Exception $e) {
            throw new GatewayException($e->getMessage());
        }
    }
}

