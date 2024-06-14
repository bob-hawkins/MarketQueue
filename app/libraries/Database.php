<?php

class Database {
    protected $db_user = DB_USER;
    protected $db_name = DB_NAME;
    protected $db_pass = DB_PASS;
    protected $db_host = DB_HOST;

    private $error;
    private $db;
    private $stmt;

    public function __construct()
    {
        $dsn = "mysql:host=" . $this->db_host . ";dbname=" . $this->db_name;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        try {
            $this->db = new PDO($dsn, $this->db_user, $this->db_pass, $options);
        } catch (PDOException $th) {
            $this->error = $th->getMessage();

            echo $this->error;
        }
    }

    public function query($sql) {
        $this->stmt = $this->db->prepare($sql);
    }

    public function bind($bind, $value) {
        $type = null;

        if(is_int($value)) $type = PDO::PARAM_INT;
        if(is_string($value)) $type = PDO::PARAM_STR;
        if(is_bool($value)) $type = PDO::PARAM_BOOL;
        if(is_null($value)) $type = PDO::PARAM_NULL;

        $this->stmt->bindValue($bind, $value, $type);
    }

    public function execute() {
        return $this->stmt->execute();
    }

    public function fetchAll() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function single() {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    public function rowCount() {
        return $this->stmt->rowCount();
    }
}