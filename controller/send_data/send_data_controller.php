<?php namespace Controller\send_data;
include "send_data_methods.php";

use function Controller\getEndpoints;
include "../auxiliary_functions.php";

$endpoints = getEndpoints($_SERVER["REQUEST_URI"], basename(__FILE__));

$json = json_decode(file_get_contents('php://input'));

$sendData = new SendData();

switch($endpoints[0])
{
    case "task":
        switch($endpoints[1])
        {
            case "update":
                $sendData->taskUpdate($json);
                break;
            
            case "insert":
                $sendData->taskInsert($json);
                break;
            
            case "delete":
                $sendData->taskDelete($_REQUEST["id"]);
                break;

            default:
                echo "Data cannot be send (task) ".__FILE__;
        }
        break;

    case "employee":
        switch($endpoints[1])
        {
            case "update":
                $sendData->employeeUpdate($json, $_REQUEST["id"]);
                break;
            
            case "insert":
                $sendData->employeeInsert($json);
                break;
            
            case "delete":
                $sendData->employeeDelete($_REQUEST["id"]);
                break;

            default:
                echo "Data cannot be send (employee) ".__FILE__;
        }
        break;

    case "customer":
        switch($endpoints[1])
        {
            case "update":
                $sendData->customerUpdate($json, $_REQUEST["id"]);
                break;
            
            case "insert":
                $sendData->customerInsert($json);
                break;
            
            case "delete":
                $sendData->customerDelete($_REQUEST["id"]);
                break;

            default:
                echo "Data cannot be send (customer) ".__FILE__;
        }
        break;

    default:
        echo __FILE__ . " error: wrong data parameter\n\r";
        print_r($endpoints);
        break;
}