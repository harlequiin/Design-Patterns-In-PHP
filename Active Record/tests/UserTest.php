<?php
declare (strict_types = 1);

use harlequiin\Patterns\ActiveRecord\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function setUp(): void
    {
        $this->pdo = $this->createMock(PDO::class);
        $this->pdoStatement = $this->createMock(PDOStatement::class);
        $this->pdo
            ->method("prepare")
            ->willReturn($this->pdoStatement);
    }

    public function testInsert()
    {
        $this->pdoStatement
            ->expects($this->once())
            ->method("execute")
            ->with(["username" => "harlequiin", "age" => 21]);
        $this->pdoStatement
            ->method("rowCount")
            ->willReturn(1);

        $user = new User($this->pdo);
        $user->setUsername("harlequiin");
        $user->setAge(21);
        $user->insert();
    }

    public function testUpdate()
    {
        $this->pdoStatement
            ->expects($this->once())
            ->method("execute")
            ->with(["id" => 1, "username" => "harlequiin", "age" => 21]);
        $this->pdoStatement
            ->method("rowCount")
            ->willReturn(1);

        $user = new User($this->pdo);
        $user->setId(1);
        $user->setUsername("harlequiin");
        $user->setAge(21);
        $user->update();
    }

    public function testDelete()
    {
        $this->pdoStatement
            ->expects($this->once())
            ->method("execute")
            ->with(["id" => 1]);

        $user = new User($this->pdo);
        $user->setId(1);
        $user->setUsername("harlequiin123");
        $user->setAge(19);
        $user->delete();
    }
}
