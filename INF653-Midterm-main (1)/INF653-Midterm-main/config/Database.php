<?php
  class Database {
        // DB Params
        //private $host = 'localhost';
        //private $db_name = 'myblog';
        //private $username = 'root';
        //private $password = '';
        private $host;
        private $db_name;
        private $username;
        private $password;
        private $conn;

        // DB Constructor
        public function __construct() {
        $this->host = getenv('HOST');
        $this->db_name = getenv('DB_NAME');
        $this->username = getenv('USERNAME');
        $this->password = getenv('PASSWORD');
        }
    
        // DB Connect
        public function connect() {
          $this->conn = null;
    
          try { 
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          } catch(PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
          }
    
          return $this->conn;
        }
  }

    ?>