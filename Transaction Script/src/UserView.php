<?php
declare(strict_types=1);

namespace harelquiin\Patterns\TransactionScript;

class UserView implements TransactionInterface
{
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo; 
    }
    public function run()
    {
        $sql = "SELECT * FROM `user` WHERE id = :id ;";
        $stmnt = $this->pdo->prepare($sql);
        $stmnt->execute(["id" => $_GET["id"]]);
        $user = $stmnt->fetch(PDO::FETCH_ASSOC);

        $html = "<head><title>Users</title></head><body>";
        $html .= "Username: {$user['username']}";
        $html .= "</html>";

        echo $html;
    }
}
