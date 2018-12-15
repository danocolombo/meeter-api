<?php

// Database.php (CLASS)

// these are the supported Meeter clients & databases
// =======================================================
// UAT dcolombo_muat
// CCC dcolombo_ccc
// WBC dcolombo_wbc
// CPV dcolombo_cpv
class Database
{

    // DB Params
    private $host = 'localhost';
    private $db_name = 'tbd';
    private $username = 'dcolombo_mapi';
    private $password = 'MR0mans1212!';
    private $conn;

    // DB Connect
    public function connect($client)
    {
        $this->conn = null;
        $this->db_name = $client;
        switch($client){
            case "CCC":
                $this->db_name = "dcolombo_ccc";
                break;
            case "CPV":
                $this->db_name = "dcolombo_cpv";
                break;
            case "UAT":
                $this->db_name = "dcolombo_muat";
                break;
            case "WBC":
                $this->db_name = "dcolombo_wbc";
        }
        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }
        
        return $this->conn;
    }
}

?>