<?php namespace Controller\get_data;
include "get_data_methods.php";

use function Controller\getEndpoints;
include "../auxiliary_functions.php";


$getData = new GetData();

$endpoints = getEndpoints($_SERVER["REQUEST_URI"], basename(__FILE__));

switch($endpoints[0])
{
    case "customers":
        switch(@$endpoints[1])
        {
            case "count":
                $getData->customersCount();
                break;
            
            case "":
                $getData->customers($_REQUEST["from"], $_REQUEST["to"]);
                break;
            
            default:
                echo "Data cannot be access (customers) ".__FILE__;
        }
        break;

    case "employees":
        switch(@$endpoints[1])
        {
            case "count":
                $getData->employeesCount();
                break;
                
            case "":
                $getData->employees($_REQUEST["from"], $_REQUEST["to"]);
                break;

            default:
                echo "Data cannot be access (employees) ".__FILE__;
        }
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
    
    case "person":
        $getData->getPerson($_REQUEST["type"], $_REQUEST["id"]);
        break;
    
    default:
        echo __FILE__ . " error: wrong data parameter";
}
