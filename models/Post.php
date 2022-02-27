<?php
Class Post {
    //db stuff
    private $conn;
    private $table = 'posts';


    //properties
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    //constructor
    public function __construct($db) {
        $this->conn = $db;
    }


    //get posts
    public function read(){
        //create query
        $query = 'SELECT 
                    c.name as category_name,
                    p.id,
                    p.category_id,
                    p.title,
                    p.author,
                    p.body,
                    p.created_at
                 FROM ' . $this->table . ' p
                    Left Outer Join Categories c
                        on c.id = p.category_id
                 ORDER BY p.created_at DESC;';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //execute order 66
        $stmt->execute();
        return $stmt;
    }

    //get single post
    public function read_single() {
        //create query
        $query = 'SELECT 
                    c.name as category_name,
                    p.id,
                    p.category_id,
                    p.title,
                    p.author,
                    p.body,
                    p.created_at
                 FROM ' . $this->table . ' p
                    Left Outer Join Categories c
                        on c.id = p.category_id
                 WHERE p.id = ?
                 LIMIT 0, 1;';

        //prepare statement
        $stmt = $this->conn->prepare($query);
        //bind id
        $stmt->bindParam(1, $this->id);
        //execute order 66
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);      
        //set properties
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
    }
    

    //create post
    public function create(){
        //create query
        $query = 'INSERT INTO ' . $this->table . '
            SET
                title = :title,
                author = :author,
                body = :body,
                category_id = :category_id';
            
        //prep statement
        $stmt = $this->conn->prepare($query);


        //clean up data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        //bind data
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':body', $this->body);
        
        //exec query
        if ($stmt->execute()){
            return true;
        }
        else {

            //print error
            printf('Error: %s.\n', $stmt->error);

            return false;
        }
    }


    //update post
    public function update(){
        //create query
        $query = 'UPDATE ' . $this->table . '
            SET
                title = :title,
                author = :author,
                body = :body,
                category_id = :category_id
            WHERE 
                id = :id;';
        
        //prep statement
        $stmt = $this->conn->prepare($query);


        //clean up data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        //bind data
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':id', $this->id);
        
        //exec query
        if ($stmt->execute()){
            return true;
        }
        else {

            //print error
            printf('Error: %s.\n', $stmt->error);

            return false;
        }
    }


    //delete
    public function delete(){
        //create query
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()){
            return true;
        }
        else {
            //print error
            printf('Error: %s.\n', $stmt->error);
            return false;
        }

    }

}





?>