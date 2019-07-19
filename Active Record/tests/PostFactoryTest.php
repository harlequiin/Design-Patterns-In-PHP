<?php
declare(strict_types=1);

use harlequiin\Patterns\ActiveRecord\PostFactory;
use PHPUnit\Framework\TestCase;
use harlequiin\Patterns\ActiveRecord\DatabaseInterface;
use harlequiin\Patterns\ActiveRecord\Post;

class PostFactoryTest extends TestCase
{
    public function setUp(): void
    {
       $this->db = $this->createMock(DatabaseInterface::class); 
    }
    public function testCreateReturnsPostInstance()
    {
        $factory = new PostFactory($this->db);
        $post = $factory->create();

        $this->assertInstanceOf(Post::class, $post);
    }
    public function testFindByUserReturnsActiveRecordArray()
    {
        $this->db->expects($this->once())
           ->method("findByAttributeValue")
           ->with("post", "user_id", 1)
           ->willReturn([["id" => 1, "text" => "...", "user_id" => 1]]);

        $factory = new PostFactory($this->db);
        $posts = $factory->findByUser(1);

        $this->assertInstanceOf(Post::class, $posts[0]);
    }

    public function testFindAllReturnsArrayOfActiveRecords()
    {
        $this->db->expects($this->once())
           ->method("findAll")
           ->with("post")
           ->willReturn([
               ["id" => 1, "text" => "...", "user_id" => 1],
               ["id" => 2, "text" => "something", "user_id" => 3]
           ]);
        
        $factory = new PostFactory($this->db);
        $posts = $factory->findAll();

        $this->assertEquals(
            2,
            count($posts)
        );
    }
}
