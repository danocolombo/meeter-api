<?php 
//--------------------------------------------------------------------------
// this returns the list of groups for a meeting or an error code for none
//--------------------------------------------------------------------
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
include_once '../config/Database.php';
include_once '../people/Person.php';
include_once 'Host.php';
$host = 'localhost';
$db_name = 'muat';
$username = 'dcolombo_mapi';
$password = 'MR0mans1212!';
$conn;

$client = $_GET["client"];


//instantiate and connect to database
// $database = new Database();

// $db = $database->connect($client);


// $person = new Person($db);
$hosts = new Host();
$hostIDs_arr = array();
$dbHostSet = "HostSet";

// $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
// Check connection
// if ($connection->connect_error) {
//     die("Connection failed: " . $connection->connect_error);
// }
$dbcon=mysqli_connect($host,$username,$password,$db_name);
if (mysqli_connect_errno()){
    die("Database connection failed: " .
        mysqli_connect_error() .
        " (" . mysqli_connect_error() . ")");
}


$stmt = $dbcon->prepare("SELECT Setting From Meeter WHERE Config = ?");
$stmt->bind_param("s", $dbHostSet);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0){
    $stmt->bind_result($ID, $Config, $Version, $Setting);
    while($stmt->fetch()){
        $dbHostSet = $Setting;
    }
    $stmt->free_result();
    $stmt->close();
}
// $ref should contain IDs seperated by "|" value.
$hostIDs_arr = explode("|", $dbHostSet);
//now get all the people that are active
$stmt = $dbcon->prepare("SELECT ID, FName, Lname From people WHERE Active = ?");
$stmt->bind_param("i", 1);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0){
    //active person
    $stmt->bind_result($ID, $FName, $LName);
    while($stmt->fetch()){
        if(array_search($ID, $hostIDs_arr)){
            array_push($hosts, $ID, $FName, $LName);
        }
    }
    $stmt->free_result();
    $stmt->close();
}
connnection.close();
//now $hosts should have the people that can host from the config entry in the database
for( $j=0;$j<$hosts.length();$j++){
    echo "$hosts[$j].ID $hosts[$j].LName, $hosts[$j].FName<br/>";
}

// $hosts should now hold the id, fname and lname of all the hosts identified in the database
// Push to "data"
// http_response_code(200);
// echo json_encode($hosts);

