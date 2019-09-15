<?php
declare (strict_types = 1);

use harlequiin\Patterns\ActiveRecord\Post;
use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
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
        $date = new DateTime();

        $this->pdoStatement
            ->expects($this->once())
            ->method("execute")
            ->with(["content" => "abcdefg", "date" => $date]);
        $this->pdoStatement
            ->method("rowCount")
            ->willReturn(1);

        $post = new Post($this->pdo);
        $post->setContent("abcdefg");
        $post->setDate($date);
        $post->insert();
    }

    public function testUpdate()
    {
        $date = new DateTime();

        $this->pdoStatement
            ->expects($this->once())
            ->method("execute")
            ->with(["id" => 1, "content" => "...", "date" => $date]);
        $this->pdoStatement
            ->method("rowCount")
            ->willReturn(1);

        $post = new Post($this->pdo);
        $post->setId(1);
        $post->setContent("...");
        $post->setDate($date);
        $post->update();
    }

    public function testDelete()
    {
        $this->pdoStatement
            ->expects($this->once())
            ->method("execute")
            ->with(["id" => 1]);

        $post = new Post($this->pdo);
        $post->setId(1);
        $post->setContent("_some content_");
        $post->setDate(new DateTime());
        $post->delete();
    }
}
