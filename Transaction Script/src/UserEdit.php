<?php
declare(strict_types=1);

namespace harelquiin\Patterns\TransactionScript;

class UserEdit implements TransactionInterface
{
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo; 
    }
    public function run()
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
