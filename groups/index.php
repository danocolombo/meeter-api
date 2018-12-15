<?php 
//--------------------------------------------------------------------
// _______ .______        ______    __    __  .______     _______.
// /  _____||   _  \      /  __  \  |  |  |  | |   _  \   /       |
// |  |  __  |  |_)  |    |  |  |  | |  |  |  | |  |_)  | |   (----`
// |  | |_ | |      /     |  |  |  | |  |  |  | |   ___/   \   \
// |  |__| | |  |\  \----.|  `--'  | |  `--'  | |  |   .----)   |
// \______| | _| `._____| \______/   \______/  | _|   |_______/
//--------------------------------------------------------------------
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include_once '../config/Database.php';
include_once 'Group.php';


if($_SERVER['REQUEST_METHOD'] == "GET"){   
    $client = $_GET["client"];
    $mtgId = $_GET["MID"];
    if(strlen($mtgId>0)){
        returnGroupsForMeeting($client, $mtgId);
    }else{
        handleGet($client);
    }
    
} else if ($_SERVER['REQUEST_METHOD"'] == "POST"){
    echo "POST not implemented yet";
} else {
    //requested method (not GET or POST) is not supported
    http_response_code(405);
}

function returnGroupsForMeeting($client, $mtgId){
    //instantiate and connect to database
    $database = new Database();
    $db = $database->connect($client);
    
    $group = new Group($db);
    
    $result = $group->getMtgGroups($mtgId);
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
                'FacID' => $facId,
                'CoFacID' => $coFacId,
                'Attendance' => $attendance,
                'Location' => $location,
                'Notes' => html_entity_decode($notes)
            );
            //             array_push($groups_arr, $group_item);
            array_push($groups_arr['data'], $group_item);
        }
        // Push to "data"
        echo json_encode($groups_arr);
    }else{
        echo  json_encode(array('message' => 'No Groups found'));
    }
}

function handleGet($client){
    //instantiate and connect to database
    $database = new Database();
    $db = $database->connect($client);
    
    $group = new Group($db);
    
    $result = $group->getAll();
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
                'FacID' => $facId,
                'CoFacID' => $coFacId,
                'Attendance' => $attendance,
                'Location' => $location,
                'Notes' => html_entity_decode($notes)
            );
//             array_push($groups_arr, $group_item);
            array_push($groups_arr['data'], $group_item);
        }
        // Push to "data"
        echo json_encode($groups_arr);
    }else{
        echo  json_encode(array('message' => 'No Groups found'));
    }
}




?>