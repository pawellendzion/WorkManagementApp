<?php namespace Controller\get_data;

class GetData
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

    #region customers methods

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
    
    #endregion

    #region employees methods

    function employees(int $from, int $to)
    {
        $sqlQuery = "SELECT * FROM employees LIMIT $from, $to";
        $result = $this->conn->query($sqlQuery);

        if ($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc()) 
            {
                echo "<tr>" .
                    "<td>" . $row["Name"] . " " . $row["Lastname"] . "</td>" .
                    "<td>" . $row["Email"] . "</td>" .
                    "<td>" . $row["Phone"] . "</td>" .
                    "<td>" . $row["Employment_date"] . "</td>" .
                    "<td>" . $row["Salary"] . "</td>" . 
                    "</tr>";
            }
        }
    }

    function employeesCount()
    {
        $sqlQuery = "SELECT COUNT(ID) FROM employees";
        $result = $this->conn->query($sqlQuery);

        print_r($result->fetch_row()[0]);
    }
    
    #endregion
}