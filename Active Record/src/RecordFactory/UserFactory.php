<?php
declare(strict_types=1);

namespace harlequiin\Patterns\ActiveRecord\RecordFactory;

use harlequiin\Patterns\ActiveRecord\ActiveRecord;
use harlequiin\Patterns\ActiveRecord\User;
use harlequiin\Patterns\ActiveRecord\DatabaseInterface;

class UserFactory implements FactoryInterface
{
    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
        
    }

    public function create(): ActiveRecord
    {
        return new User($this->db, ["username" => ""]);
    }

    public function find($id): ActiveRecord
    {
        $userData = $this->db->findById("user", $id)[0];
        $user = new User($this->db, $userData);
        return $user;
    }

    public function findAll(): array
    {
        $data = $this->db->findAll("user");
        $users = [];
        
        foreach ($data as $userData) {
            $users[] = new User($this->db, $userData);
        }

        return $users;
    }
}
