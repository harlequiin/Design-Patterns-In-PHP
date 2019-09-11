<?php
declare(strict_types=1);

namespace harlequiin\Patterns\TableDataGateway;

use harlequiin\Patterns\TableDataGateway\UserGateway;
use PHPUnit\Framework\TestCase;

class UserGatewayTest extends TestCase
{
    public function setUp(): void
    {
        $this->pdoStatement = $this->createMock(\PDOStatement::class);

        $this->pdo = $this->createMock(\PDO::class);
        $this->pdo
             ->method("prepare")
             ->willReturn($this->pdoStatement);
    }

    public function testfind()
    {
        $user = new \stdClass();
        $user->id = 1;
        $user->username = "marisudris";

        $expected = $resultSet = [
            $user
        ];
        $this->pdoStatement->method('fetchAll')
             ->willReturn($resultSet);

        $gateway = new UserGateway($this->pdo);
        $result = $gateway->find(1);

        $this->assertEquals(
            $expected,
            $result
        );
    }

    public function testfindByUsername()
    {
        $user = new \stdClass();
        $user->id = 3;
        $user->username = "user123";

        $expected = $resultSet = [
            $user
        ];
        $this->pdoStatement->method('fetchAll')
             ->willReturn($resultSet);

        $gateway = new UserGateway($this->pdo);
        $result = $gateway->findByUsername("user123");

        $this->assertEquals(
            $expected,
            $result
        );
    }

    public function testUpdate()
    {
        $this->pdoStatement->expects($this->once())
             ->method("execute")
             ->with(["id" => 1, "username" => "maris.udris.lv"]);

        $gateway = new UserGateway($this->pdo);
        $gateway->update(1, "maris.udris.lv");
    }

    public function testInsert()
    {
        $this->pdoStatement->expects($this->once())
             ->method("execute")
             ->with(["anotheruser"]);

        $gateway = new UserGateway($this->pdo);
        $gateway->insert("anotheruser");
    }

    public function testDelete()
    {
        $this->pdoStatement->expects($this->once())
             ->method("execute")
             ->with([2]);

        $gateway = new UserGateway($this->pdo);
        $gateway->delete(2);
    }
}
