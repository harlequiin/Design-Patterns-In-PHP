<?php
declare(strict_types=1);

namespace harlequiin\Patterns\ActiveRecord\RecordFactory;

use harlequiin\Patterns\ActiveRecord\ActiveRecord;
use harlequiin\Patterns\ActiveRecord\Post;
use harlequiin\Patterns\ActiveRecord\DatabaseInterface;

class PostFactory implements FactoryInterface
{
    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
        
    }

    public function create(): ActiveRecord
    {
        return new Post($this->db, ["text" => "", "user_id" => null]);
    }

    public function findByUser($id): array
    {
        $data = $this->db->findByAttributeValue("post", "user_id", $id);
        $posts = [];
        
        foreach ($data as $post) {
            $posts[] = new Post($this->db, $post);
        }
        return $posts;
    }

    public function find($id): ActiveRecord
    {
        $data = $this->db->findById("post", $id)[0];
        $post = new Post($this->db, $data);
        return $post;
    }

    public function findAll(): array
    {
        $data = $this->db->findAll("post");
        $posts = [];
        
        foreach ($data as $post) {
            $posts[] = new Post($this->db, $post);
        }

        return $posts;
    }
}
