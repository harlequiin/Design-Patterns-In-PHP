<?php
declare(strict_types=1);

namespace harlequiin\Patterns\ActiveRecord;

use PDO;
use TheSeer\Tokenizer\Exception;

class User extends ActiveRecord
{
    /**
     * @var string table name
     */
    protected const TABLE = "user";

    /**
     * @var string user's username
     */

    private $username;
    /**
     * @var int user's age
     */

    private $age;

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username= $username;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    protected function collectProperties(): array
    {
        return [
            "username" => $this->getUsername(),
            "age" => $this->getAge()
        ];
    }

    public static function find(int $id): User
    {
        $sql = "SELECT * FROM " . self::TABLE . " WHERE `id` = :id ;";

        try {
            $pdoStatement = $this->pdo->prepare($sql);
            $pdoStatement->execute(["id" => $id]);
            $pdoObject = $pdoStatement->fetch(PDO::FETCH_OBJ);
            $user = new User($this->pdo);
            $user->setId($pdoObject->id);
            $user->setUsername($pdoObject->username);
            $user->setAge($pdoObject->age);
            return $user;
        } catch (Exception $e) {
            throw new ActiveRecordException($e->getMessage());
        }
    }
}
