<?php 

    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    //Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    //Instantiate Author object
    $author = new Author($db);

    // author read query
    $result = $author->read();

    //get row count
    $num = $result->rowCount();

    //check if any authors
    if( $num > 0) {
        //initialize authors array
        $auth_arr = array();
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $auth_item = array(
                'id' => $id,
                'author' => $author
                
            );

            array_push($auth_arr,$auth_item);
        }
        //turn it to JSON & output
        echo json_encode($auth_arr);
    } else {
        //no categories
        echo json_encode(array('message' => 'No Authors Found'));
    }