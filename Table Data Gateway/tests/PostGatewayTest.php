<?php
declare(strict_types=1);

namespace harlequiin\Patterns\TableDataGateway;

use PHPUnit\Framework\TestCase;
use harlequiin\Patterns\TableDataGateway\PostGateway;

class PostGatewayTest extends TestCase
{
    public function setUp(): void
    {
        $this->pdoStatement = $this->createMock(\PDOStatement::class);

        $this->pdo = $this->createMock(\PDO::class);
        $this->pdo
             ->method("prepare")
             ->willReturn($this->pdoStatement);
    }

    public function testFind()
    {
        $post = new \stdClass();
        $post->id = 1;
        $post->text = "some text";

        $expected = $resultSet = [$post];

        $this->pdoStatement->method('fetchAll')
             ->willReturn($resultSet);

        $gateway = new PostGateway($this->pdo);
        $result = $gateway->find(1);

        $this->assertEquals(
            $expected,
            $result
        );
    }

    public function testFindByUser()
    {
        $post1 = new \stdClass();
        $post1->id = 1;
        $post1->text = "some text";
        $post1->user_id = 1;

        $post2 = new \stdClass();
        $post2->id = 2;
        $post2->text = "another text";
        $post1->user_id = 1;

        $expected = $resultSet = [
            $post1,
            $post2
        ];
        $this->pdoStatement->method('fetchAll')
             ->willReturn($resultSet);

        $gateway = new PostGateway($this->pdo);

        $result = $gateway->findByUser(1);

        $this->assertEquals(
            $expected,
            $result
        );
    }

    public function testUpdate()
    {
        $this->pdoStatement->expects($this->once())
             ->method("execute")
             ->with(["id" => 2, "text" => "abcd xyz"]);

        $gateway = new PostGateway($this->pdo);
        $gateway->update(2, "abcd xyz");
    }

    public function testInsert()
    {
        $this->pdoStatement->expects($this->once())
             ->method("execute")
             ->with(["some text", 1]);

        $gateway = new PostGateway($this->pdo);
        $gateway->insert("some text", 1);
    }

    public function testDelete()
    {
        $this->pdoStatement->expects($this->once())
             ->method("execute")
             ->with([2]);

        $gateway = new PostGateway($this->pdo);
        $gateway->delete(2);
    }
}
