<?php namespace Controller\get_data;

include "get_data_methods.php";

$getData = new GetData();

$url = $_SERVER["REQUEST_URI"];
$action = substr($url, strrpos($url, '/') + 1);

switch($_REQUEST["data"])
{
    case "customers":
        $getData->customers($_REQUEST["from"], $_REQUEST["to"]);
        break;

    case "customersCount":
        $getData->customersCount();
        break;

    case "employees":
        $getData->employees($_REQUEST["from"], $_REQUEST["to"]);
        break;
        
    case "employeesCount":
        $getData->employeesCount();
        break;
    
    case "tasks":
        $getData->tasks();
        break;

    case "task":
        $getData->task($_REQUEST["id"]);
        break;

    case "list":
        $getData->listOf($_REQUEST["ofWhat"], $_REQUEST["type"]);
        break;
    
    case "leader-team":
        $getData->leaderTeam($_REQUEST["type"], $_REQUEST["id"]);
        break;  

    default:
        echo __FILE__ . " error: wrong data parameter";
}
