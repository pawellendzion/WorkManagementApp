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
        $sendData->task($json);
        break;
    
    default:
        break;
}