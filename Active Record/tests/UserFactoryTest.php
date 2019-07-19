<?php
declare(strict_types=1);

use harlequiin\Patterns\ActiveRecord\DatabaseInterface;
use harlequiin\Patterns\ActiveRecord\UserFactory;
use harlequiin\Patterns\ActiveRecord\PostFactory;
use harlequiin\Patterns\ActiveRecord\User;
use PHPUnit\Framework\TestCase;

class UserFactoryTest extends TestCase
{
    public function setUp(): void
    {
        $this->pf = $this->createMock(PostFactory::class);
        $this->db = $this->createMock(DatabaseInterface::class);
        
    }
    public function testFindByIdReturnsActiveRecord()
    {
        $this->db->expects($this->once())
           ->method("findById")
           ->with("user", 1)
           ->willReturn([["id" => 1, "username" => "maris"]]);

        $finder = new UserFactory($this->db, $this->pf);

        $user = $finder->find(1);

        $this->assertInstanceOf(User::class, $user);
    }

    public function testFindAllReturnsArrayOfActiveRecords()
    {
        $this->db->expects($this->once())
           ->method("findAll")
           ->with("user")
           ->willReturn([
               ["id" => 1, "username" => "maris"],
               ["id" => 2, "username" => "toms"]
           ]);
        
        $finder = new UserFactory($this->db, $this->pf);

        $users = $finder->findAll();

        $this->assertEquals(
            2,
            count($users)
        );
    }
}
