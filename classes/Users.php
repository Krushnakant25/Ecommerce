<?php
    class DB {
        private $conn;
        public function __construct()
        {
            $this->conn = new mysqli('localhost','root','','ecommerce'); 
            if($this->conn->connect_error) {
            die("Connection Failed: ". $this->conn->connect_error);
            }   
            $this->conn->set_charset("utf8mb4");
        }

        

        
    }
?>