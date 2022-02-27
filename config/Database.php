<?php
    class Database {
        //db params
        private $host = 'ble5mmo2o5v9oouq.cbetxkdyhwsb.us-east-1.rds.amazonaws.com';
        private $db_name = 'myblog';
        private $username = 'auei9s8p213v36dk';
        private $password = '';
        private $conn;

        //password
        public function __construct(){
            $this->password = getenv('JAWSDB_PW', false);
        }

        //db connect
        public function connect() {
            $this->conn = null;

            try {

                $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name,
                                      $this->username,
                                      $this->password);
                
                //set errormode
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch(PDOException $e) {
                echo 'Connection Error: ' . $e->getMessage();
            }
            return $this->conn;
        }

    }




?>