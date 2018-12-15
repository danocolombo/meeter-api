<?php 
class Group {
    //db stuff
    private $conn;
    private $table = 'groups';
    
    // Groups properties
    public $id;
    public $mtgId;
    public $gender;
    public $title;
    public $facId;
    public $coFacId;
    public $attendance;
    public $location;
    public $notes;
    
    //Constructor with DB
    public function __construct($db){
        $this->conn = $db;
    }
    
    // get the groups
    public function getAll(){
        // create query
        $query = 'SELECT * FROM groups ORDER BY ID DESC';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    
    
    
    
}


?>