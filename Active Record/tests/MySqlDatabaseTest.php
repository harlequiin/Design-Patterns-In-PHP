<?php
declare(strict_types=1);

use harlequiin\Patterns\ActiveRecord\MySqlDatabase;
use PHPUnit\Framework\TestCase;

class MySqlDatabaseTest extends TestCase
{
    public function setUp(): void
    {
        $this->pdo = $this->createMock(\PDO::class);
        $this->pdoStatement = $this->createMock(\PDOStatement::class);
    }

    public function testCreatePassesCorrectSqlString()
    {
        $fields = ["id" => 1, "username" => "maris"];


        $this->pdo->expects($this->once())
            ->method('prepare')
            ->with('INSERT INTO `user`(`id`, `username`) VALUES (:id, :username) ;')
            ->willReturn($this->pdoStatement);

        $this->pdoStatement->expects($this->once())
            ->method('execute')
            ->with($fields);

        $this->pdoStatement->expects($this->once())
            ->method('rowCount')
            ->willReturn(1);

        $db = new MySqlDatabase($this->pdo);
        $db->create("user", $fields);
        
    }

    public function testCreateThrowsPDOException()
    {
        $this->pdo->expects($this->once())
             ->method('prepare')
             ->willReturn($this->pdoStatement);

        $this->pdoStatement->expects($this->once())
            ->method('rowCount')
            ->willReturn(0);

        $db = new MySqlDatabase($this->pdo);

        $this->expectException('PDOException');
        $db->create("", []);
    }

    public function testUpdatePassesCorrectSqlString()
    {
        $this->pdo->expects($this->once())
            ->method('prepare')
            ->with("UPDATE `user` SET `username` = :username AND `age` = :age WHERE `id` = 1 ;")
            ->willReturn($this->pdoStatement);

        $this->pdoStatement->expects($this->once())
            ->method('rowCount')
            ->willReturn(1);

        $db = new MySqlDatabase($this->pdo);
        $db->update("user", 1, ["username" => "maris", "age" => "27"]);
    }

    public function testUpdateThrowsPDOException()
    {
        $this->pdo->expects($this->once())
             ->method('prepare')
             ->willReturn($this->pdoStatement);

        $this->pdoStatement->expects($this->once())
            ->method('rowCount')
            ->willReturn(0);

        $db = new MySqlDatabase($this->pdo);

        $this->expectException('PDOException');
        $db->update("", 0, []);
    }

    public function testDeleteByIdPassesCorrectSqlString()
    {
        $this->pdo->expects($this->once())
             ->method('prepare')
             ->with("DELETE FROM `user` WHERE `id` = :id ;")
             ->willReturn($this->pdoStatement);

        $this->pdoStatement->expects($this->once())
             ->method('execute')
             ->with(["id" => 1]);

        $this->pdoStatement->expects($this->once())
            ->method('rowCount')
            ->willReturn(1);
        
        $db = new MySqlDatabase($this->pdo);
        $db->deleteById("user", 1);
    }
    public function testDeleteByIdThrowsPDOException()
    {
        $this->pdo->expects($this->once())
             ->method('prepare')
             ->willReturn($this->pdoStatement);

        $this->pdoStatement->expects($this->once())
            ->method('rowCount')
            ->willReturn(0);

        $db = new MySqlDatabase($this->pdo);

        $this->expectException('PDOException');
        $db->deleteById("user", 1);
    }

    public function testFindByIdReturnsAssociativeArray()
    {
        $expected = [
            ["id" => 1, "username" => "maris"]
        ];

        $this->pdo->expects($this->once())
             ->method("prepare")
             ->with("SELECT * FROM `post` WHERE `id` = ? ;")
             ->willReturn($this->pdoStatement);
        $this->pdoStatement->expects($this->once())
             ->method("fetchAll")
             ->willReturn($expected);

        $db = new MySqlDatabase($this->pdo);
        $result = $db->findById("post", 1);

        $this->assertEquals(
            $expected,
            $result
        );
    }

    public function testFindAllReturnsAssociativeArray()
    {
        $expected = [
            ["id" => 1, "username" => "maris"],
            ["id" => 2, "username" => "toms"]
        ];

        $this->pdo->expects($this->once())
             ->method("query")
             ->with("SELECT * FROM `comment` ;")
             ->willReturn($this->pdoStatement);
        $this->pdoStatement->expects($this->once())
             ->method("fetchAll")
             ->willReturn($expected);

        $db = new MySqlDatabase($this->pdo);
        $result = $db->findAll("comment");

        $this->assertEquals(
            $expected,
            $result
        );
    }

}
