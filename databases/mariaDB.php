v<?php
class mariaDB
{
    private $host = 'localhost';
    private $database_name = 'webservices';
    private $username = 'senac';
    private $password = 'senac123';
    private $conexao;

    public function dbConnection()
    {
        $this -> conexao = null;
        try{
            $this ->conexao = new PDO(
                "mysql:host={$this->host};dbname={$this->database_name}",
                $this-> username,
                $this->password
            );
            $this->conexao->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
        } catch (PDOException $exception){
            echo 'connetion error:' . $exception->getMessage();
        }
        return $this->conexao;
    }
}