<?php namespace Controller\send_data;

class SendData
{
    private $conn;

    function __construct()
    {
        $serverName = "localhost";
        $userName = "root";
        $password = "";
        $dbName = "dbwmapp";

        $this->conn = new \mysqli($serverName, $userName, $password, $dbName);

        if ($this->conn->connect_error)
            die("Connection failed: " . $this->conn->connect_error);
    }

    function __destruct()
    {
        $this->conn->close();
    }

    function task($json)
    {
        $sqlQuery = "UPDATE tasks SET ".
                    "Title = '$json->title', ".
                    "ID_Customer = $json->customer, ".
                    "ID_Team = ". ($json->team == 0 ? "NULL" : $json->team) .", ".
                    "Deadline = '$json->deadline', ".
                    "Status = '$json->status' ".
                    "WHERE ID = $json->id;";

        $this->conn->query($sqlQuery);
        
        if ($this->conn->errno)
            echo "Some error occure when trying to save data";
    }
}