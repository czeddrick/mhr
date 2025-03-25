<?php
require_once(LIB_PATH . DS . "config.php");

class Database {
    var $sql_string = '';
    var $error_no = 0;
    var $error_msg = '';
    var $query = '';
    public $conn;
    public $last_query;
    private $magic_quotes_active;
    private $real_escape_string_exists;

    function __construct() {
        $this->open_connection();
    }

    public function open_connection() {
        try {
            $this->conn = new PDO("mysql:host=" . server . ";dbname=" . database_name, user, pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Problem in database connection! Contact administrator! " . $e->getMessage());
        }
    }

    function InsertThis($sql = '') {
        $this->sql_string = $sql;
        $this->query = $this->conn->prepare($this->sql_string);

        return $this->query->execute();
    }

    function setQuery($sql = '') {
        try {
            $this->sql_string = $sql;
            $this->query = $this->conn->prepare($this->sql_string);
            $this->query->execute();
        } catch (PDOException $e) {
            die("Failed to execute query: " . $e->getMessage());
        }
    }

    function executeQuery() {
        try {
            $this->query->execute();
        } catch (PDOException $e) {
            die("Failed to execute query: " . $e->getMessage());
        }
    }

    function loadResultList() {
        return $this->query->fetchAll(PDO::FETCH_OBJ);
    }

    function loadSingleResultAssoc() {
        return $this->query->fetch(PDO::FETCH_ASSOC);
    }

    public function num_rows() {
        return $this->query->rowCount();
    }

    function loadSingleResult() {
        return $this->query->fetch(PDO::FETCH_OBJ);
    }

    function getFieldsOnOneTable($tbl_name) {
        $this->setQuery("DESC " . $tbl_name);
        $rows = $this->loadResultList();

        $fields = [];
        foreach ($rows as $row) {
            $fields[] = $row->Field;
        }

        return $fields;
    }

    public function fetch_array($result) {
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function insert_id() {
        return $this->conn->lastInsertId();
    }

    public function affected_rows() {
        return $this->query->rowCount();
    }

    public function escape_value($value) {
        return $this->conn->quote($value);
    }

    public function close_connection() {
        $this->conn = null;
    }
}

$mydb = new Database();
?>
