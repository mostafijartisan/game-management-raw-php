<?php

class DatabaseClass {

    private $host = '127.0.0.1';
    private $dbname = 'web_internet_25_janu';
    private $username = 'root';
    private $password = '';
  
    public function connect(){
        try {
            $pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            
            // Set the PDO error mode to exception
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // echo "Database connected";
            return $pdo;
        
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function dataFetch($table){

        // db connect
        $pdo = $this->connect();

        // SQL QUERY 
        $query =  "SELECT * FROM $table";

        $stmt = $pdo->prepare($query); 

        // EXECUTING THE QUERY 
        $stmt->execute(); 

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id, $table){

        // db connect
        $pdo = $this->connect();

        // query
        $sql = "DELETE FROM $table WHERE id = :id";

        // Prepare the statement
        $stmt = $pdo->prepare($sql);

        // Bind the parameter
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Execute the statement
        $stmt->execute();

        return true;
    }

    // Game script start ---------------------
    public function gameStore($post){

        if(isset($post)){

            // echo '<pre>';
            // var_dump($post['name']);
            // die();

            // db connect
            $pdo = $this->connect();

            // prepare sql and bind parameters
            $stmt = $pdo->prepare("INSERT INTO games (name) VALUES (:name)");

            $stmt->bindParam(':name', $name);
          
            // insert a row
            $name = $post['name'];
            $stmt->execute();

            if($stmt->rowCount()){
                return true;
            } else {
                return false;
            }
           
        }
    }

    public function gameEdit($post){

        if(isset($post)){

            // echo '<pre>';
            // var_dump($post['name']);
            // die();

            // db connect
            $pdo = $this->connect();

            // Your UPDATE query
            $id = $post['id'];
            $name = $post['name'];
            $sql = "UPDATE games SET name = :name WHERE id = :id";

            // Prepare the statement
            $stmt = $pdo->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            // Execute the statement
            $stmt->execute();

            header('Location: http://localhost/web_internet/game-list.php');
            return true;
           
        }
    }
    // Game script end ---------------------

    // Slot script start ---------------------
    public function slotStore($post){

        if(isset($post)){

            // db connect
            $pdo = $this->connect();

            // prepare sql and bind parameters
            $stmt = $pdo->prepare("INSERT INTO slots (name, start_time, end_time) VALUES (:name, :start_time, :end_time)");

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':start_time', $start_time);
            $stmt->bindParam(':end_time', $end_time);
          
            // insert a row
            $name = $post['name'];
            $start_time = $post['start_time'];
            $end_time = $post['end_time'];

            $stmt->execute();

            if($stmt->rowCount()){
                return true;
            } else {
                return false;
            }
           
        }
    }

    public function slotEdit($post){

        if(isset($post)){

            // db connect
            $pdo = $this->connect();

            // Your UPDATE query
            $id = $post['id'];
            $name = $post['name'];
            $start_time = $post['start_time'];
            $end_time = $post['end_time'];

            $sql = "UPDATE slots SET name = :name, start_time = :start_time, end_time = :end_time  WHERE id = :id";

            // Prepare the statement
            $stmt = $pdo->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':start_time', $start_time, PDO::PARAM_STR);
            $stmt->bindParam(':end_time', $end_time, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            // Execute the statement
            $stmt->execute();

            header('Location: http://localhost/web_internet/slot-list.php');
            return true;
           
        }
    }

    // Slot script end ---------------------

    // Slot script start ---------------------
        public function studentStore($post){

            if(isset($post)){
    
                // db connect
                $pdo = $this->connect();
    
                // prepare sql and bind parameters
                $stmt = $pdo->prepare("INSERT INTO students (name, student_id, batch, department) VALUES (:name, :student_id, :batch, :department)");
    
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':student_id', $student_id);
                $stmt->bindParam(':batch', $batch);
                $stmt->bindParam(':department', $department);
              
                // insert a row
                $name = $post['name'];
                $student_id = $post['student_id'];
                $batch = $post['batch'];
                $department = $post['department'];
    
                $stmt->execute();
    
                if($stmt->rowCount()){
                    return true;
                } else {
                    return false;
                }
               
            }
        }
    
        public function studentEdit($post){
    
            if(isset($post)){
    
                // db connect
                $pdo = $this->connect();
    
                // Your UPDATE query
                $id = $post['id'];
                $name = $post['name'];
                $student_id = $post['student_id'];
                $batch = $post['batch'];
                $department = $post['department'];
    
                $sql = "UPDATE students SET name = :name, student_id = :student_id, batch = :batch, department = :department  WHERE id = :id";
    
                // Prepare the statement
                $stmt = $pdo->prepare($sql);
    
                // Bind the parameters
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':student_id', $student_id, PDO::PARAM_STR);
                $stmt->bindParam(':batch', $batch, PDO::PARAM_STR);
                $stmt->bindParam(':department', $department, PDO::PARAM_STR);
    
                // Execute the statement
                $stmt->execute();
    
                header('Location: http://localhost/web_internet/student-list.php');
                return true;
               
            }
        }
    
    // Slot script end ---------------------

    // Slot booking script start ---------------------
        public function slotBookingDataFetch(){

            // db connect
            $pdo = $this->connect();

            // SQL QUERY 
            $query = "
                    SELECT 
                        students.name as student_name, 
                        games.name as game_name, 
                        slots.name as slot_name, 
                        slots.start_time as slot_start_time, 
                        slots.end_time as slot_end_time, 
                        slot_bookings.date,
                        slot_bookings.id 
                    FROM 
                        slot_bookings
                    LEFT JOIN 
                        students ON slot_bookings.student_id = students.id
                    LEFT JOIN 
                        games ON slot_bookings.game_id = games.id
                    LEFT JOIN 
                        slots ON slot_bookings.slot_id = slots.id
                ";


            $stmt = $pdo->prepare($query); 

            // EXECUTING THE QUERY 
            $stmt->execute(); 

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }


        public function slotBookinStore($post){

            // validation start --------------
            // db connect
            $pdo = $this->connect();

            // Your multi WHERE query
            $slot_id = $post['slot_id'];
            $date = $post['date'];
            $sql = "SELECT * FROM slot_bookings WHERE slot_id = :slot_id AND date = :date";

            // Prepare the statement
            $stmt = $pdo->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':slot_id', $slot_id, PDO::PARAM_STR);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);

            // Execute the statement
            $stmt->execute();

            if(count($stmt->fetchAll(PDO::FETCH_ASSOC)) > 0){
                return 'exist';
            }

            // echo '<pre>';
            // // var_dump();
            // var_dump($post);
            // exit;

            if(isset($post)){
    
                // db connect
                $pdo = $this->connect();
    
                // prepare sql and bind parameters
                $stmt = $pdo->prepare("INSERT INTO slot_bookings (student_id, game_id, slot_id, date) VALUES (:student_id, :game_id, :slot_id, :date)");
    
                $stmt->bindParam(':student_id', $student_id);
                $stmt->bindParam(':game_id', $game_id);
                $stmt->bindParam(':slot_id', $slot_id);
                $stmt->bindParam(':date', $date);
              
                // insert a row
                $student_id = $post['student_id'];
                $game_id = $post['game_id'];
                $slot_id = $post['slot_id'];
                $date = $post['date'];
    
                $stmt->execute();
    
                if($stmt->rowCount()){
                    return 'create';
                } else {
                    return 'error';
                }
               
            }
        }

    // Slot script end ---------------------

    
    





}
?>