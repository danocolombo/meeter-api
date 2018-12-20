<?php 
//--------------------------------------------------------------------------
// this returns the list of groups for a meeting or an error code for none
//--------------------------------------------------------------------
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
include_once '../config/Database.php';
include_once 'Group.php';
$client = $_GET["client"];
$mtgId = $_GET["MID"];
//instantiate and connect to database
$database = new Database();
$db = $database->connect($client);

$group = new Group($db);

$result = $group->getGroupsForMtgForm($mtgId);
// get row count
$num = $result->rowCount();

// check if Groups exist
if ($num>0){
    // there are groups found, make array to hold data
    $groups_arr = array();
    $groups_arr['data'] = array();
    while($row=$result->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $group_item = array(
            'ID' => $id,
            'MtgID' => $mtgId,
            'Gender' => $gender,
            'Title' => $title,
            'FacFirstName' => $fFName,
            'FacLastName' => $fLName,
            'CoFirstName' => $cFName,
            'CoLastName' => $cLName,
            'Attendance' => $attendance,
            'Location' => $location
        );
        //             array_push($groups_arr, $group_item);
        array_push($groups_arr['data'], $group_item);
    }
    // Push to "data"
    http_response_code(200);
    echo json_encode($groups_arr);
}else{
    http_response_code(404);
    echo json_endode(array("message" => "No groups defined for meeting."));
}

