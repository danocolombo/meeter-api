<?php 
//--------------------------------------------------------------------------
// this returns the list of groups for a meeting or an error code for none
//--------------------------------------------------------------------
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
include_once '../config/Database.php';
$client = $_GET["client"];
//instantiate and connect to database
$database = new Database();

$db = $database->connect($client);

//first we get the hosts defined in the meeter table

$query = $db->prepare("SELECT Setting From Meeter WHERE Config = 'HostSet'");
$query->execute();
$query->bind_result($setting);
while($query->fetch()){
    $hostString = $setting;
}
$query->close();
$hostID = explode("|", $hostString);

// then we get all the users that are active and get the associated names
//now get the people reference for the hostIDs
$peeps = array();
$query = $db->prepare("SELECT ID, FName, LName FROM people WHERE Active = 1");
$query->execute();
$query->bind_result($id, $fn, $ln);
while($query->fetch()){
    $name = $fn . " " . $ln;
    $peeps[$id] = $name;
}
$query->close();
//=====================================
// now loop through the hosts getting their names
//=====================================
$host_arr = array();
$host_arr['hosts'] = array();
foreach ($hostID as $id){
    foreach($peeps as $pID => $name){
        if($id == $pID){
            $host_item = array(
                'ID' => $id,
                'HostName' => $name
            );
        }
        array_push($host_arr['hosts'], $host_item);
    }
}

// Push to "data"
http_response_code(200);
echo json_encode($host_arr);

