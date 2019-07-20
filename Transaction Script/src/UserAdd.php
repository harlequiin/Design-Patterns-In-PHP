<?php
declare(strict_types=1);

namespace harelquiin\Patterns\TransactionScript;

class UserAdd implements TransactionInterface
{
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo; 
    }
    public function run()
    {
        
        $sql = "INSERT INTO `user`(`username`) VALUES ( :username ) ;";
        $stmnt = $this->pdo->prepare($sql);
        $stmnt->execute(["username" => $_POST["username"]]);

        header("Location: /");
    }
}
