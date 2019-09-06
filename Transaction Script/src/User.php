<?php
declare(strict_types=1);

namespace harelquiin\Patterns\TransactionScript;

use PDO;

class User
{
    /**
     * @var PDO database access
     */
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo; 
    }

    public function listUsers()
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

    public function viewUser()
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

    public function addUser()
    {
        
        $sql = "INSERT INTO `user`(`username`) VALUES ( :username ) ;";
        $stmnt = $this->pdo->prepare($sql);
        $stmnt->execute(["username" => $_POST["username"]]);

        header("Location: /");
    }

    public function editUser()
    {
        $sql = "UPDATE `user` SET `username` = :username WHERE id = :id ;";
        $stmnt = $this->pdo->prepare($sql);
        $stmnt->execute([
            "username" => $_POST["username"],
            "id" => $_POST["id"]
        ]);

        $id = urlencode($_POST["id"]);
        header("Location: /user={$id}");
    }
}
