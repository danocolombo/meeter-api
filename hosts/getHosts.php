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
$db_name = 'dcolombo_muat';
$username = 'dcolombo_mapi';
$password = 'MR0mans1212!';
$conn;

$client = $_GET["client"];


//instantiate and connect to database
// $database = new Database();

// $db = $database->connect($client);


// $person = new Person($db);
$hosts = new Host();
$hostIDs_arr[Host] = array();
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


$stmt = $dbcon->prepare("SELECT ID, Config, Version, Setting From Meeter WHERE Config = \"HostSet\"");
// $stmt->bind_param("s", $dbHostSet);
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
echo "dbhostSet: $dbhostSet<br/>";
$hostIDs_arr = explode("|", $dbHostSet);
for($x=0;$x<$hostIDs_arr.length;$x++){
    echo "$x. $hostIDs_arr[$x]<br/>";
}
echo "done";
exit();
//now get all the people that are active
$one = 1;
$stmt = $dbcon->prepare("SELECT ID, FName, Lname From people WHERE Active = ?");
$stmt->bind_param("i", $one);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0){
    // there are groups found, make array to hold data
    $hosts_arr = array();
    $hosts_arr['data'] = array();
    //active person
    $stmt->bind_result($ID, $FName, $LName);
    while($stmt->fetch()){
//         if(array_search($ID, $hostIDs_arr)){
            $host_item = array(
                'ID' => $id,
                'MtgID' => $ID,
                'FName' => $FName,
                'LName' => $LName
            );
            //             array_push($groups_arr, $group_item);
            array_push($hosts_arr['data'], $host_item);
//         }
    }
    $stmt->close();
    $dbcon->close();
    // Push to "data"
    http_response_code(200);
    echo json_encode($groups_arr);
}else{
    http_response_code(404);
    echo json_endode(array("message" => "No hosts defined in system."));
}

