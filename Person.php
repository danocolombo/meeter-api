<?php

// --------------------------------------------------------------------
// .______ _______ .______ _______. ______ .__ __.
// | _ \ | ____|| _ \ / | / __ \ | \ | |
// | |_) | | |__ | |_) | | (----`| | | | | \| |
// | ___/ | __| | / \ \ | | | | | . ` |
// | | | |____ | |\ \----.----) | | `--' | | |\ |
// | _| |_______|| _| `._____|_______/ \______/ |__| \__|
//
// --------------------------------------------------------------------
class Person
{

    // db stuff
    private $conn;

    private $table = 'groups';

    // Person properties
    public $id;
    public $active;
    public $address;
    public #aos;
    public $areasServed;
    public $city;
    public $covenant;
    public $email1;
    public $email2;
    public $fName;
    public $interests;
    public $joyAreas;
    public $lName;
    public $notes;
    public $phone1;
    public $phone2;
    public $reasonsToServe;
    public $recoveryArea;
    public $recoverySince;
    public $spiritualGifts;
    public $state;
    public $zipcode;

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // get the groups
    function getAll()
    {
        $query = 'SELECT 
            ID as id, 
            Active as active,
            Address as address,
            AOS as aos,
            AreasServed as areasServed,
            City as city,
            Covenant as covenant,
            Email1 as email1,
            Email2 as email2,
            FName as fName,
            Interests as interests,
            JoyAreas as joyAreas,
            LName as lName,
            Notes as notes,
            Phone1 as phone1,
            Phone2 as phone2,
            ReasonsToServe as reasonsToServe,
            RecoveryArea as recoveryArea,
            RecoverySince as recoverySince,
            SpiritualGifts as spiritualGifts,
            State as state,
            Zipcode as zipcode';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function getPerson($pid)
    {
        $query = 'SELECT
            ID as id, 
            Active as active,
            Address as address,
            AOS as aos,
            AreasServed as areasServed,
            City as city,
            Covenant as covenant,
            Email1 as email1,
            Email2 as email2,
            FName as fName,
            Interests as interests,
            JoyAreas as joyAreas,
            LName as lName,
            Notes as notes,
            Phone1 as phone1,
            Phone2 as phone2,
            ReasonsToServe as reasonsToServe,
            RecoveryArea as recoveryArea,
            RecoverySince as recoverySince,
            SpiritualGifts as spiritualGifts,
            State as state,
            Zipcode as zipcode 
            FROM people WHERE id = ' . $pid . ' ORDER BY id';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}

?>