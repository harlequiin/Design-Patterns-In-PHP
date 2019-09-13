<?php
declare(strict_types=1);

namespace harlequiin\Patterns\RowDataGateway;

use PDO;

class UserGateway
{
    /**
     * @var PDO PHP Data Object
     */
    private $pdo;

    /**
     * @var string table name
     */
    private const TABLE = "user";

    /**
     * @var int ID of the record
     */
    private $id;

    /**
     * @var string user's name
     */
    private $username;

    /**
     * @var int age of the user
     */
    private $age;
    
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

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    public function insert()
    {
        $sql = "INSERT INTO " . self::TABLE . "(`username`, `age`) VALUES(:username, :age); ";

        try {
            $this->pdo->prepare($sql)->execute([
                "username" => $this->getUsername(),
                "age" => $this->getAge()
            ]);
        } catch (\Exception $e) {
            throw new GatewayException($e->getMessage());
        }
    }

    public function update()
    {
        $sql = "UPDATE " . self::TABLE . " SET=`username`=:username, `age`=:age) WHERE `id`=:id; ";

        try {
            $this->pdo->prepare($sql)->execute([
                "id" => $this->getId(),
                "username" => $this->getUsername(),
                "age" => $this->getAge()
            ]);
        } catch (\Exception $e) {
            throw new GatewayException($e->getMessage());
        }
    }

    public function delete()
    {
        $sql = "DELETE FROM " . self::TABLE . " WHERE `id`=:id; ";

        try {
            $this->pdo->prepare($sql)->execute([
                "id" => $this->getId(),
            ]);
        } catch (\Exception $e) {
            throw new GatewayException($e->getMessage());
        }
    }
}

