<?php
class User extends DataBase
{
    public function getUser($userName)
    {
        $sql = "SELECT * FROM user WHERE name = :userName ;";
        $result = $this->connect()->prepare($sql);
        $result->bindParam('userName', $userName, PDO::PARAM_STR);
        $result->execute();
        return $result->fetch();
    }
    public function insertUser($userName, $password) {
        $sql = "INSERT INTO user(name, password)
                VALUES(? , ?);";
        $result = $this->connect()->prepare($sql);
        $result->bindParam(1, $userName);
        $result->bindParam(2, $password);
        $result->execute();
    }
}