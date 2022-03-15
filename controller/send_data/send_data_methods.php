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

    function taskUpdate($json)
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
        {
            echo "Some error has occure when trying to update data";
            echo $this->conn->error;
        }
    }

    function taskInsert($json)
    {
        $sqlQuery = "INSERT INTO tasks (Title, ID_Customer, ID_Team, Deadline, Status)".
                    "VALUES ('$json->title', $json->customer, "
                    . ($json->team == 0 ? "NULL" : $json->team) .", '$json->deadline', '$json->status')";

        $this->conn->query($sqlQuery);
        
        if ($this->conn->errno)
            echo "Some error has occure when trying to insert data\n".$this->conn->error;
    }

    function taskDelete($id)
    {
        $sqlQuery = "DELETE FROM tasks WHERE ID=$id";

        $this->conn->query($sqlQuery);

        if ($this->conn->errno)
            echo "Some error has occure when trying to delete task\n".$this->conn->error;
    }

    function employeeUpdate($json, $id)
    {
        $sqlQuery = "UPDATE employees SET ".
                    "Name = '" . $json->firstname . "', ".
                    "Lastname = '" . $json->lastname . "', ".
                    "Phone = '" . $json->phone . "', ".
                    "Email = '" . $json->email . "', ".
                    "Employment_date = '" . $json->{"0"} . "', ".
                    "Salary = " . $json->{"1"} . ", ".
                    "Team = " . $json->{"2"} . " WHERE ID = $id ";

        $this->conn->query($sqlQuery);

        if ($this->conn->errno)
        {
            echo "Some error has occure when trying to update data";
            echo $this->conn->error;
        }
    }

    function employeeInsert($json)
    {
    }

    function employeeDelete($id)
    {
    }

    function customerUpdate($json, $id)
    {
        $sqlQuery = "UPDATE customers SET ".
                    "Name = '" . $json->firstname . "', ".
                    "Lastname = '" . $json->lastname . "', ".
                    "Phone = '" . $json->phone . "', ".
                    "Email = '" . $json->email . "', ".
                    "Last_Contact = '" . $json->{"0"} . "' WHERE ID = $id ";

        $this->conn->query($sqlQuery);

        if ($this->conn->errno)
        {
            echo "Some error has occure when trying to update data";
            echo $this->conn->error;
        }
    }

    function customerInsert($json)
    {
    }

    function customerDelete($id)
    {
    }
}