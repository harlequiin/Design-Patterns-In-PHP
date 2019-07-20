<?php
declare(strict_types=1);

namespace harelquiin\Patterns\TransactionScript;

class UserList implements TransactionInterface
{
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo; 
    }
    public function run()
    {
        $sql = "SELECT * FROM `user` ;";
        $this->pdo->query($sql);
        $users = $$this->pdo->fetchAll(PDO::FETCH_ASSOC);

        $html = "<head><title>Users</title></head><body>";
        $list = "<ul>";
        foreach($users as $user) {
            $list .= "<li>{$user['username']}</li>";
        }

        $list .= "</ul>";
        $html .= $list;

        echo $html;
    }
}
