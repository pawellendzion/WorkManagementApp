<?php namespace Controller\get_data;

class GetData
{
    private $conn;

    function __construct()
    {
        $serverName = "localhost";
        $userName = "GetData";
        $password = "getdata123";
        $dbName = "dbwmapp";

        $this->conn = new \mysqli($serverName, $userName, $password, $dbName);

        if ($this->conn->connect_error)
            die("Connection failed: " . $this->conn->connect_error);
    }

    function __destruct()
    {
        $this->conn->close();
    }

    function customers(int $from, int $to)
    {
        $sqlQuery = "SELECT * FROM customers LIMIT $from, $to";
        $result = $this->conn->query($sqlQuery);

        if ($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc()) 
            {
                echo "<tr>" .
                    "<td>" . $row["Name"] . " " . $row["Lastname"] . "</td>" .
                    "<td>" . $row["Email"] . "</td>" .
                    "<td>" . $row["Phone"] . "</td>" .
                    "<td>" . ($row["Last_Contact"]  ?? "Not Contacted") . "</td>" . 
                    "</tr>";
            }
        }
    }

    function customersCount()
    {
        $sqlQuery = "SELECT COUNT(ID) FROM customers";
        $result = $this->conn->query($sqlQuery);

        print_r($result->fetch_row()[0]);
    }
}