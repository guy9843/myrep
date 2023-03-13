<?php 

    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,
        Access-Control-Allow-Methods,Authorization,X-Requested-With ');


    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    //Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    //Instantiate quote object
    $quote_object = new Quote($db);

    //Get the raw quote data
    $data = json_decode(file_get_contents("php://input"));

    //Set ID to update
    $quote_object->id = $data->id;

    //Delete the quote
    if($quote_object->delete()) {
        $quote_item = array(
            'id' => $quote_object->id
        );
        echo json_encode($quote_item);
    } else {
        //if no quotes
        echo json_encode (array('message' => 'No Quotes Found'));
    }