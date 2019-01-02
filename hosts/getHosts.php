<?php 
//--------------------------------------------------------------------------
// this returns the list of people that are identified as hosts in the 
// meeter configuration table
//--------------------------------------------------------------------
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
include_once '../config/Database.php';
$client = $_GET["client"];
$database = new Database();
$db = $database->iConnect($client);
$dbHostSet = "";
//get HostSet configuration from database
$sql = "SELECT ID, Config, Version, Setting FROM Meeter WHERE Config =\"HostSet\"";
$result = $db->query($sql);
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $dbHostSet = $row["Setting"];
    }
}

// $ref should contain IDs seperated by "|" value.
$hostIDs_arr = explode("|", $dbHostSet);

//now get all the people to match the configuration values
$hosts_arr = array();
$hosts_arr['hosts'] = array();
$sql = "SELECT ID, FName, LName FROM people WHERE Active = 1 AND length(LName)>0 ORDER BY FName";
$result = $db->query($sql);
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        if(array_search($row["ID"], $hostIDs_arr)){
            // they are a host
            $host_item = array(
                'ID' => $row["ID"],
                'FName' => $row["FName"],
                'LName' => $row["LName"]
            );
            array_push($hosts_arr['hosts'], $host_item);
        }
    }
}else{
    echo "no data returned";
    die();
}
$database->iClose();
http_response_code(200);
echo json_encode($hosts_arr);

