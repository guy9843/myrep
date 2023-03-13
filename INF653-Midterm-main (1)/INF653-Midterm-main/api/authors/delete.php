<?php 

    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,
        Access-Control-Allow-Methods,Authorization,X-Requested-With ');


    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    //Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    //Instantiate author object
    $author_object = new Author($db);

    //Get the raw author data
    $data = json_decode(file_get_contents("php://input"));
    
    //Set ID to update
    $author_object->id = $data->id;
    //validate the input
    if(empty($author_object->id)) {
        echo json_encode(array('message' => 'Missing Required Parameters'));
            return;
    }
    //Delete the author
    if($author_object->delete()) {
        $auth_item = array(
            'id' => $author_object->id
        );
        echo json_encode($auth_item);
    } else {
        echo json_encode (array('message' => 'No Author Found'));
    }