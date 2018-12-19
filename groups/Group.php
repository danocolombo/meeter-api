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
    function getGroupById($gID){
        $query = 'SELECT
            ID as id, MtgID as mtgId, Gender as gender, Title as title, FacID as facId, CoFacID as coFacId, Attendance as coFacId, Location as location, Notes as notes
             FROM groups WHERE id = ' . $gID;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function getGroupListingForMtgForm($mtgId){
        
        $query = 'SELECT groups.ID as id, groups.Gender as gender, groups.Title as title, fac.FName as fFName, fac.LName as fLName, cofac.FName as cFName, cofac.LName as cLName,
        groups.Location, groups.Attendance
        FROM groups INNER JOIN people fac ON groups.FacID = fac.ID
        INNER JOIN people cofac ON groups.CoFacID = cofac.ID
        WHERE groups.MtgID = ' . $mtgId . ' ORDER BY groups.Gender, groups.Title DESC';
        
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    
    
    
}


?>