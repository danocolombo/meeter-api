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
    function getAll(){
        $query = 'SELECT 
            ID as id, MtgID as mtgId, Gender as gender, Title as title, FacID as facId, CoFacID as coFacId, Attendance as coFacId, Location as location, Notes as notes
             FROM groups ORDER BY id';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    function getMtgGroups($mtgId){
        $query = 'SELECT
            ID as id, MtgID as mtgId, Gender as gender, Title as title, FacID as facId, CoFacID as coFacId, Attendance as coFacId, Location as location, Notes as notes
             FROM groups WHERE mtgId = ' . $mtgId . ' ORDER BY id';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    
    
    
}


?>