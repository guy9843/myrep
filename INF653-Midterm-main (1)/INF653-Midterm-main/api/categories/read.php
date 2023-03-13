<?php 

    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    //Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    //Instantiate Category object
    $category_object = new Category($db);

    // Category read query
    $result = $category_object->read();

    //get row count
    $num = $result->rowCount();

    //check if any categories
    if( $num > 0) {
        //initialize category array
        $cat_arr = array();
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $cat_item = array(
                'id' => $id,
                'category' => $category
                
            );
            array_push($cat_arr,$cat_item);
        }
        //turn it to JSON & output
        echo json_encode($cat_arr);
    } else {
        //no categories
        echo json_encode(array('message' => 'categoryId Not Found'));
    }