<?php
declare(strict_types=1);

use harlequiin\Patterns\RowDataGateway\UserFinder;
use harlequiin\Patterns\RowDataGateway\UserGateway;
use PHPUnit\Framework\TestCase;

class UserFinderTest extends TestCase
{
    public function setUp(): void
    {
        $this->pdo = $this->createMock(PDO::class);
        $this->pdoStatement = $this->createMock(PDOStatement::class);

        $this->pdo
            ->method("prepare")
            ->willReturn($this->pdoStatement);
    }

    public function testFind()
    {
        $pdoObject = new stdClass();
        $pdoObject->id = 1;
        $pdoObject->username = "harlequiin";
        $pdoObject->age = 18;

        $gateway = new UserGateway($this->pdo);
        $gateway->setUsername("harlequiin");
        $gateway->setId(1);
        $gateway->setAge(18);

        $this->pdoStatement
            ->expects($this->once())
            ->method("execute")
            ->with(["id" => 1]);
        $this->pdoStatement
            ->expects($this->once())
            ->method("fetch")
            ->willReturn($pdoObject);

        $finder = new UserFinder($this->pdo);

        $result = $finder->find(1);

        $this->assertEquals(
            $gateway,
            $result
        );
    }

    public function testFindByUsername()
    {
        $pdoObject = new stdClass();
        $pdoObject->id = 2;
        $pdoObject->username = "user123";
        $pdoObject->age = 28;

        $gateway = new UserGateway($this->pdo);
        $gateway->setId(2);
        $gateway->setUsername("user123");
        $gateway->setAge(28);

        $this->pdoStatement
            ->expects($this->once())
            ->method("execute")
            ->with(["username" => "user123"]);
        $this->pdoStatement
            ->expects($this->once())
            ->method("fetch")
            ->willReturn($pdoObject);

        $finder = new UserFinder($this->pdo);

        $result = $finder->findByUsername("user123");

        $this->assertEquals(
            $gateway,
            $result
        );
    }

}
