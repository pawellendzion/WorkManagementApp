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
                echo "<tr onclick=\"PersonPageHandler.toggle('customer',". $row["ID"] .")\"".
                    "class=\"person\" id=\"employee-". $row["ID"] ."\">" .

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
        $sqlQuery = "SELECT employees.ID, employees.Name, Lastname, Email, Phone, Employment_date, teams.Name as 'TeamName'
                     FROM employees LEFT JOIN teams ON Team = teams.ID LIMIT $from, $to";
        $result = $this->conn->query($sqlQuery);

        if ($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc()) 
            {
                echo "<tr onclick=\"PersonPageHandler.toggle('employee',". $row["ID"] .")\"".
                    "class=\"person\" id=\"employee-". $row["ID"] ."\">" .
                    
                    "<td>" . $row["Name"] . " " . $row["Lastname"] . "</td>" .
                    "<td>" . $row["Email"] . "</td>" .
                    "<td>" . $row["Phone"] . "</td>" .
                    "<td>" . $row["Employment_date"] . "</td>" .
                    "<td>" . $row["TeamName"] . "</td>" . 
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

    function task($id)
    {
        $sqlQuery = "SELECT tasks.ID, CONCAT(customers.Name, ' ', customers.Lastname) as customer, teams.Name as team_name, 
                    CONCAT(employees.Name, ' ', employees.Lastname) as leader, Title, Deadline, Status
                    FROM customers JOIN tasks ON tasks.ID_Customer = customers.ID
                    LEFT JOIN teams ON tasks.ID_Team = teams.ID
                    LEFT JOIN employees ON teams.Leader = employees.ID
                    WHERE tasks.ID = $id;";

        $result = $this->conn->query($sqlQuery);

        if ($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();

            $jsonResult["ID"] = $row["ID"];
            $jsonResult["Status"] = $row["Status"];
            $jsonResult["Customer"] = $row["customer"];
            $jsonResult["Team"] = $row["team_name"];
            $jsonResult["Leader"] = $row["leader"];
            $jsonResult["Title"] = $row["Title"];
            $jsonResult["Deadline"] = $row["Deadline"];

            echo json_encode($jsonResult);
        }
    }

    #endregion

    function listOf($ofWhat, $type)
    {
        $getLeaders = "";
        if ($type == "leaders")
        {
            $type = "employees";
            $getLeaders = "JOIN teams ON $type.ID = Leader";
        }
        
        if ($ofWhat == "Fullname")
            $ofWhat = "CONCAT($type.Name, ' ', $type.Lastname)";

        $sqlQuery = "SELECT $type.ID, $ofWhat FROM $type $getLeaders";
        $result = $this->conn->query($sqlQuery);

        $jsonResult = null;

        if ($result->num_rows > 0)
            while ($row = $result->fetch_array())
                $jsonResult[$row[0]] = $row[1];

        echo json_encode($jsonResult);
    }

    function leaderTeam($type, $id)
    {
        $where = "";
        if ($type == "team")
            $where = "WHERE teams.ID = $id";
        else
            $where = "WHERE employees.ID = $id";

        $sqlQuery = "SELECT teams.ID, employees.ID
                    FROM teams JOIN employees ON Leader = employees.ID $where;";
        
        $result = $this->conn->query($sqlQuery);

        $row = $result->fetch_array();

        $jsonResult["team_ID"] = $row[0];
        $jsonResult["leader_ID"] = $row[1];

        echo json_encode($jsonResult);
    }

    function getPerson($type, $id)
    {
        if ($type == "employee")
        {
            $sqlQuery = "SELECT employees.ID, employees.Name, Lastname, Email, Phone,
                         Employment_date as 'Employment date', Salary, teams.Name as 'Team name'
                         FROM employees LEFT JOIN teams ON Team = teams.ID WHERE employees.ID = $id";
        }
        else
            $sqlQuery = "SELECT * FROM $type"."s WHERE ID = $id";

        $result = $this->conn->query($sqlQuery)->fetch_assoc();

        foreach($result as $key => $value)
        {
            $jsonResult[$key] = $value;
        }

        echo json_encode($jsonResult);
    }
}