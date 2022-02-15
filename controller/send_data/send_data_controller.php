<?php namespace Controller\send_data;

include "send_data_methods.php";

$json = json_decode(file_get_contents('php://input'));

$sendData = new SendData();

$url = $_SERVER["REQUEST_URI"];
$action = substr($url, strrpos($url, '/') + 1);

switch($action)
{
    case "task":
        $sendData->task($json);
        break;
    
    default:
        break;
}