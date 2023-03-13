<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
}

if ($method === 'GET' && isset($_GET['id']))
{
   include_once 'read_single.php';
}
else if($method === 'GET')
{
    include_once 'read.php';
}

if($method === 'POST')
{
    include_once 'create.php';
}

if($method === 'PUT')
{
    //run update
    include_once 'update.php';
}

if($method === 'DELETE')
{
    //run delete
    include_once 'delete.php';
}
