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
    

    //read blog post
    $result = $post->read(1);
    //get rowcount
    $num = $result->rowCount();

    //check if posts
    if($num>0) { 
        $posts_arr = array();
        $posts_arr['data'] = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $post_item = array(
                'id' => $id,
                'title' => $title,
                'body' => html_entity_decode($body),
                'author' => $author,
                'category_id' => $category_id,
                'category_name' => $category_name
            );
            //push to data
            array_push($posts_arr['data'],
                        $post_item);
        }
        
        //turn to json
        echo json_encode($posts_arr);

    }
    else {
        //if no posts found
        echo json_encode(
            array('message'=>'no posts found')
        );
    }


?>