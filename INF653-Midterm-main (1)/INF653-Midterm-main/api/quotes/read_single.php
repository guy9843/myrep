<?php 

    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    //Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    //Instantiate quote object
    $quote = new Quote($db);

    //Get ID from URL if set
    $quote->id = isset($_GET['id']) ? $_GET['id'] : die();
    

    //Call read_single method 
    if($quote->read_single()) {
        //json data, create array
        $quote_arr = array(
            'id'=> $quote->id,
            'quote' => $quote->quote,
            'author' => $quote->author,
            'category' => $quote->category
        );
        //convert to JSON data
        print_r(json_encode($quote_arr));
    } else {
        //if no quotes
        echo json_encode(array('message' => 'No Quotes Found'));
    }

    

    
    