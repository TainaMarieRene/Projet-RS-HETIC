<?php

class DBXAMP
{
    private string $host = "localhost";
    private string $user = "root";
    private string $password = "";
    private string $db_name = "unilink";
    public PDO $status;

    public function __construct(){
        try {
            $dsn = "mysql:host=$this->host;dbname=$this->db_name";
            $this->state = new PDO($dsn,"$this->user","$this->password",array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
            $this->state->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->state->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return $e;
        }
    }

}