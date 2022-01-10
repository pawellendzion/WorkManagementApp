<?php namespace Controller\get_data;

include "get_data_methods.php";

$getData = new GetData();

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

    default:
        echo __FILE__ . " error: wrong data parameter";
}
