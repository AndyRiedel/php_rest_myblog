<?php
    //headerz
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';


    //instantiate db & connect
    $database = new Database();
    $db = $database->connect();

    //instantiate post object
    $post = new Post($db);
    
    //get id from url
    $post->id = isset($_GET['id']) ? $_GET['id'] : die();//exit if no id passed

    //get post
    $post->read_single();

    //create an array
    $post_arr = array(
        'id' => $post->id,
        'title' => $post->title,
        'author' => $post->author,
        'body' => $post->body,
        'category_id' => $post->category_id,
        'category_name' => $post->category_name
    );

    //make json
    print_r(json_encode($post_arr));

?>