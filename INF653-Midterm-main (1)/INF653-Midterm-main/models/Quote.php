<?php
    class Quote {
        //DB stuff
        private $conn;
        private $table = 'quotes';

        //Quote Properties
        public $id;
        public $quote;
        public $categoryId;
        public $category;
        public $authorId;
        public $author;

        //Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        //get quotes
        public function read() {
            //create query
            if((isset($_GET['authorId'])) && (isset($_GET['categoryId']))){
                $query = 'SELECT 
                q.id,
                q.quote,
                a.author as author,
                q.authorId,
                c.category as category,
                q.categoryId
                FROM
                    '. $this->table  .' q
                LEFT JOIN
                    categories c ON q.categoryId = c.id
                LEFT JOIN
                    authors a ON q.authorId = a.id
                WHERE
                    q.authorId = ? AND q.categoryId = ?';
        
                //prepare statement
                $stmt = $this->conn->prepare($query);

                //Bind ID
                $stmt->bindParam(1,$this->authorId);
                $stmt->bindParam(2,$this->categoryId);

                //Execute query
                $stmt->execute();
            }
            else if(isset($_GET['authorId'])){
                $query = 'SELECT 
                q.id,
                q.quote,
                a.author as author,
                q.authorId,
                c.category as category,
                q.categoryId
                FROM
                    '. $this->table  .' q
                LEFT JOIN
                    categories c ON q.categoryId = c.id
                LEFT JOIN
                    authors a ON q.authorId = a.id
                WHERE
                    q.authorId = ?
                ';
        
                //prepare statement
                $stmt = $this->conn->prepare($query);

                //Bind ID
                $stmt->bindParam(1,$this->authorId);

                //Execute query
                $stmt->execute();
            }
            else if(isset($_GET['categoryId'])){
                $query = 'SELECT 
                q.id,
                q.quote,
                a.author as author,
                q.authorId,
                c.category as category,
                q.categoryId
                FROM
                    '. $this->table  .' q
                LEFT JOIN
                    categories c ON q.categoryId = c.id
                LEFT JOIN
                    authors a ON q.authorId = a.id
                WHERE
                    q.categoryId = ?
                ';
        
                //prepare statement
                $stmt = $this->conn->prepare($query);

                //Bind ID
                $stmt->bindParam(1,$this->categoryId);

                //Execute query
                $stmt->execute();
            }
            
            else {
                $query = 'SELECT 
                    q.id,
                    q.quote,
                    a.author as author,
                    q.authorId,
                    c.category as category,
                    q.categoryId
                FROM
                    '. $this->table  .' q
                LEFT JOIN
                    categories c ON q.categoryId = c.id
                LEFT JOIN
                    authors a ON q.authorId = a.id
                ORDER BY
                    q.id ASC';
        
                //prepare statement
                $stmt = $this->conn->prepare($query);

                //Execute query
                $stmt->execute();
            }
            return $stmt;
        }

        //Get single Quote
        public function read_single() {
            //create query

            $query = 'SELECT 
                q.id,
                q.quote,
                a.author as author,
                q.authorId,
                c.category as category,
                q.categoryId
            FROM
                '. $this->table  .' q
            LEFT JOIN
                categories c ON q.categoryId = c.id
            LEFT JOIN
                authors a ON q.authorId = a.id
            WHERE
                q.id = ?
            LIMIT 0,1';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Bind ID
            $stmt->bindParam(1,$this->id);
        
            //Execute query
            $stmt->execute();

            if($stmt->rowCount() > 0){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->quote = $row['quote'];
                $this->author = $row['author'];
                $this->authorId = $row['authorId'];
                $this->category = $row['category'];
                $this->categoryId = $row['categoryId'];
                return true;
            }
            return false;
        }

        //Create Quote
        public function create() {
            //Create query
            $query = 'INSERT INTO ' . $this->table . 
                ' (quote, authorId, categoryId) VALUES (:quote, :authorId, :categoryId)';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->authorId = htmlspecialchars(strip_tags($this->authorId));
            $this->categoryId = htmlspecialchars(strip_tags($this->categoryId));

            //bind the data
            $stmt ->bindParam(':quote',$this->quote);
            $stmt ->bindParam(':authorId',$this->authorId);
            $stmt ->bindParam(':categoryId',$this->categoryId);

            //execute query
            if ($stmt->execute()){
                $this->id = $this->conn->lastInsertId();
                return true;
            }

            //Print error if something goes wrong
            printf("Error: %s.\n",$stmt->error);
            return false;
        }

        //Update Quote
        public function update() {
            //Create query
            $query = 'UPDATE ' . 
                $this->table . '
                SET
                    quote = :quote,
                    authorId = :authorId,
                    categoryId = :categoryId
                WHERE
                    id = :id';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->authorId = htmlspecialchars(strip_tags($this->authorId));
            $this->categoryId = htmlspecialchars(strip_tags($this->categoryId));
            $this->id = htmlspecialchars(strip_tags($this->id));

            //bind the data
            $stmt ->bindParam(':quote',$this->quote);
            $stmt ->bindParam(':authorId',$this->authorId);
            $stmt ->bindParam(':categoryId',$this->categoryId);
            $stmt ->bindParam(':id',$this->id);

            //execute query
            if ($stmt->execute()){
                return true;
            }

            //Print error if something goes wrong
            printf("Error: %s.\n",$stmt->error);
            return false;
        }

        //Delete Post
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

            if ($stmt->rowCount() > 0){
                return true;
            }
            return false;
        }


    }

