<?php

    class Author {
        //DB stuff
        private $conn;
        private $table = 'authors';

        //Properties
        public $id;
        public $author;

        //Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        //get authors
        public function read() {
            //create query
            $query = 'SELECT
                id,
                author
            FROM
                ' . $this->table . '
            ORDER BY
                id ASC';

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //Execute query
            $stmt->execute();

            return $stmt;

        }

        //Get single author
        public function read_single() {
            //create query
            $query = 'SELECT
                id,
                author
            FROM
                ' . $this->table . '
            WHERE
                id = ?
            LIMIT 0,1';
            
            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Bind ID
            $stmt->bindParam(1,$this->id);

            //Execute query
            $stmt->execute();

            if($stmt->rowCount() > 0){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->author = $row['author'];
                return true;
            }
            return false;

        }

        //Create author
        public function create() {
            //Create query
            $query = 'INSERT INTO ' . 
                $this->table . '
                SET
                    author = :author';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->author = htmlspecialchars(strip_tags($this->author));


            //bind the data
            $stmt ->bindParam(':author',$this->author);

            //execute query
            if ($stmt->execute()){
                $this->id = $this->conn->lastInsertId();
                return true;
            }

            //Print error if something goes wrong
            printf("Error: %s.\n",$stmt->error);
            return false;
        }

        //Update author
        public function update() {
            //Create query
            $query = 'UPDATE ' . 
                $this->table . '
                SET
                    author = :author
                WHERE
                    id = :id';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->id = htmlspecialchars(strip_tags($this->id));

            //bind the data
            $stmt ->bindParam(':author',$this->author);
            $stmt ->bindParam(':id',$this->id);

            //execute query
            if ($stmt->execute()){
                $this->id = $this->conn->lastInsertId();
                return true;
            }

            //Print error if something goes wrong
            printf("Error: %s.\n",$stmt->error);
            return false;
        }

        //Delete Author
        public function delete() {
            //Create Query
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->id = htmlspecialchars(strip_tags($this->id));

            //bind the data
            $stmt ->bindParam(':id',$this->id);

            //execute query
            $stmt->execute();
            if ($stmt->rowCount() >0){
                return true;
            }

            //Print error if something goes wrong
            printf("Error: %s.\n",$stmt->error);
            return false;

        }

    }