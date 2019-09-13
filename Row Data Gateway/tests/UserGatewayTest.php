<?php
declare(strict_types=1);

use harlequiin\Patterns\RowDataGateway\UserGateway;
use PHPUnit\Framework\TestCase;

class UserGatewayTest extends TestCase
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
        $gateway = new UserGateway($this->pdo);
        $gateway->setUsername("harlequiin123");
        $gateway->setAge(18);

        $this->pdoStatement
            ->expects($this->once())
            ->method("execute")
            ->with(["username" => "harlequiin123", "age" => 18]);

        $gateway->insert();
    }

    public function testUpdate()
    {
        $gateway = new UserGateway($this->pdo);
        $gateway->setUsername("harlequiin123");
        $gateway->setId(1);
        $gateway->setAge(18);

        $this->pdoStatement
            ->expects($this->once())
            ->method("execute")
            ->with(["id" => 1, "username" => "harlequiin123", "age" => 18]);

        $gateway->update();
    }

    public function testDelete()
    {
        $gateway = new UserGateway($this->pdo);
        $gateway->setUsername("harlequiin123");
        $gateway->setId(1);
        $gateway->setAge(18);

        $this->pdoStatement
            ->expects($this->once())
            ->method("execute")
            ->with(["id" => 1]);

        $gateway->delete();
    }

}
