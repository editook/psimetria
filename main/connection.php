<?php
class Connection
{
    private $host = "localhost";
    private $db = "p022tea";
    //local
    private $user = "root";
    private $password = "";
    //production
    //private $user = "psimetria022";
    //private $password = ";Ld]NfaIxBeS";


    private $mysqli = null;

    public function __construct($db='')
    {
        $this->connect($db);
    }

    private function connect($db='')
    {
        if( empty($db) )
            $db = $this->db;

        $this->mysqli = new mysqli($this->host, $this->user, $this->password, $db);
        if ($this->mysqli->connect_errno)
            die ("Failed to connect to MySQL: (" . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error);
        $this->mysqli->set_charset('utf8mb4');
    }

    public function getLastInsertedID()
    {
        return $this->mysqli->insert_id;
    }

    public function execute_query($query)
    {
        return mysqli_query($this->mysqli, $query);
    }

    public function getRealEscapeString($string)
    {
        return mysqli_real_escape_string($this->mysqli, trim($string));
    }
}