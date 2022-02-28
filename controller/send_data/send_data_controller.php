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
            
            default:
                echo "Data cannot be send (task) ".__FILE__;
        }
        break;
    
    default:
        break;
}