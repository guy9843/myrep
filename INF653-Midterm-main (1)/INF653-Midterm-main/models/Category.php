<?php

    class Category {
        //DB stuff
        private $conn;
        private $table = 'categories';

        //Properties
        public $id;
        public $category;

        //Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        //get categories
        public function read() {
            //create query
            $query = 'SELECT
                id,
                category
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

        //Get single category
        public function read_single() {
            //create query
            $query = 'SELECT
                id,
                category
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
                $this->category = $row['category'];
                return true;
            }
            return false;

        }

        //Create category
        public function create() {
            //Create query
            $query = 'INSERT INTO ' . 
                $this->table . '
                SET
                    category = :category';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->category = htmlspecialchars(strip_tags($this->category));


            //bind the data
            $stmt ->bindParam(':category',$this->category);

            //execute query
            if ($stmt->execute()){
                $this->id = $this->conn->lastInsertId();
                return true;
            }

            //Print error if something goes wrong
            printf("Error: %s.\n",$stmt->error);
            return false;

        }

        //Update Category
        public function update() {
            //Create query
            $query = 'UPDATE ' . 
                $this->table . '
                SET
                    category = :category
                WHERE
                    id = :id';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->category = htmlspecialchars(strip_tags($this->category));
            $this->id = htmlspecialchars(strip_tags($this->id));

            //bind the data
            $stmt ->bindParam(':category',$this->category);
            $stmt ->bindParam(':id',$this->id);

            //execute query
            if ($stmt->execute()){
                return true;
            }

            //Print error if something goes wrong
            printf("Error: %s.\n",$stmt->error);
            return false;
        }

        //Delete Category
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