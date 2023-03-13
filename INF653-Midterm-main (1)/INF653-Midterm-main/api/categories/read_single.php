<?php 

    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    //Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    //Instantiate category object
    $category_object = new Category($db);

    //Get ID from URL
    $category_object->id = isset($_GET['id']) ? $_GET['id'] : die();

    if($category_object->read_single()) {
        $cat_arr = array(
            'id'=> $category_object->id,
            'category' => $category_object->category
        );
        //convert to JSON data
        print_r(json_encode($cat_arr));
    }
    else {
        echo json_encode(array('message' => 'categoryId Not Found'));
    }

    