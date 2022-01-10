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

    #region tasks methods

    function tasks()
    {
        $sqlQuery = "SELECT tasks.ID, CONCAT(customers.Name, ' ', customers.Lastname) as customer, teams.Name as team_name, 
                    CONCAT(employees.Name, ' ', employees.Lastname) as leader, Title, Deadline, Status
                    FROM customers JOIN tasks ON tasks.ID_Customer = customers.ID
                    LEFT JOIN teams ON tasks.ID_Team = teams.ID
                    LEFT JOIN employees ON teams.Leader = employees.ID;";
        
        $result = $this->conn->query($sqlQuery);

        if ($result->num_rows > 0)
        {
            $jsonResult = null;

            $temp = function($status, $rowResult, &$funcResult)
            {
                $funcResult[$status][$rowResult["ID"]]["Title"] = $rowResult["Title"];
                $funcResult[$status][$rowResult["ID"]]["Customer"] = $rowResult["customer"];
                $funcResult[$status][$rowResult["ID"]]["Team_name"] = $rowResult["team_name"];
                $funcResult[$status][$rowResult["ID"]]["Leader"] = $rowResult["leader"];
                $funcResult[$status][$rowResult["ID"]]["Deadline"] = $rowResult["Deadline"];
            };

            while($row = $result->fetch_assoc()) 
            {
                switch($row["Status"])
                {
                    case "to do": 
                        $temp("to-do", $row, $jsonResult);
                        break;
                    case "working on": 
                        $temp("working-on", $row, $jsonResult);
                        break;
                    case "completed": 
                        $temp("completed", $row, $jsonResult);
                        break;
                }
            }
            echo json_encode($jsonResult);
        }
    }

    #endregion
}