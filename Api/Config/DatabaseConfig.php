<?php
class DatabaseConfigd
{
    private $pdo = null;
    public function inteagrate()
    {
        if ($this->pdo == null) {
             try {
                $server = 'localhost';
                $user = 'root';
                $password = '';
                $database = 'docs_gall';

                $this->pdo = new PDO(dsn: "mysql:host:$server",username: $user, password: $password);
                $this->pdo->setAttribute(attribute: PDO::ATTR_ERRMODE, value: PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e)
        {
            exit(json_encode(value: [
                'success' => false,
                'message' => 'Database connection failed'. $e->getMessage()
            ]));
        }
        }
        return $this->pdo;
           
    }
}