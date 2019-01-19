<?php 
//--------------------------------------------------------------------
//
//      resetEmail.php
//
//  the intention of this service is to get an email or user name and 
//  check the user table for an email, and then send a link to reset
//  their password.
//--------------------------------------------------------------------
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include_once '../config/Database.php';
include_once 'Person.php';


if($_SERVER['REQUEST_METHOD'] == "PUT"){   
    $client = $_GET["client"];
    $pid = $_GET["possibleUser"];
    
    //check if possibleUser is email "user_email"
    
    //check if possibleUser is user name "user_login"
    
    //if they are either of the above, set password_reset = 
    
    
    
    
    
    if(strlen($pid>0)){
        returnPersonForID($client, $pid);
    }else{
        returnAll($client);
    }
    
} else if ($_SERVER['REQUEST_METHOD"'] == "POST"){
    echo "POST not implemented yet";
    http_response_code(424);  // Failed Dependency
} else {
    //requested method (not GET or POST) is not supported
    http_response_code(405);  //    Method Not Allowed
}

function returnPersonForID($client, $pid){
    //instantiate and connect to database
    $database = new Database();
    $db = $database->connect($client);
    
    $person = new Person($db);
    
    $result = $person->getPerson($pid);
    // get row count
    $num = $result->rowCount();
    
    // check if Groups exist
    if ($num>0){
        // there are groups found, make array to hold data
        $return_arr = array();
        $return_arr['data'] = array();
        while($row=$result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $return_item = array(
                'ID' => $id,
                'FirstName' => $fName,
                'LastName' => $lName,
                'Street' => $address,
                'City' => $city,
                'State' => $state,
                'Zipcode' => $zipcode,
                'Phone1' => $phone1,
                'Phone2' => $phone2,
                'Email1' => $email1,
                'Email2' => $email2,
                'Notes' => html_entity_decode($notes),
                'Active' => $active,
                'AOS' => $aos,
                'AreasServed' => html_entity_decode($areasServed),
                'Covenant' => $covenant,
                'Interests' => html_entity_decode($interests),
                'JoyAreas' => html_entity_decode($joyAreas),
                'ReasonsToServe' => html_entity_decode($reasonsToServe),
                'RecoveryArea' => html_entity_decode($recoveryArea),
                'RecoverySince' => $recoverySince,
                'SpiritualGifts' => html_entity_decode($spiritualGifts)
            );
            array_push($return_arr['data'], $return_item);
        }
        // Push to "data"
        echo json_encode($return_arr);
    }else{
        $return_arr = array();
        $return_arr['data'] = array();
        $return_item = array('message' => 'no people information id');
        array_push($return_arr['data'], $return_item);
        
        // Push to "data"
        echo json_encode($return_arr);
    }
}

function returnAll($client){
    //instantiate and connect to database
    $database = new Database();
    $db = $database->connect($client);
    
    $person = new Person($db);
    
    $result = $person->getAll();
    // get row count
    $num = $result->rowCount();
    
    // check if people exist
    if ($num>0){
        // there are people found, make array to hold data
        $people_arr = array();
        $people_arr['data'] = array();
        while($row=$result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $people_item = array(
                'ID' => $id,
                'FirstName' => $fName,
                'LastName' => $lName,
                'Street' => $address,
                'City' => $city,
                'State' => $state,
                'Zipcode' => $zipcode,
                'Phone1' => $phone1,
                'Phone2' => $phone2,
                'Email1' => $email1,
                'Email2' => $email2,
                'Notes' => html_entity_decode($notes),
                'Active' => $active,
                'AOS' => $aos,
                'AreasServed' => html_entity_decode($areasServed),
                'Covenant' => $covenant,
                'Interests' => html_entity_decode($interests),
                'JoyAreas' => html_entity_decode($joyAreas),
                'ReasonsToServe' => html_entity_decode($reasonsToServe),
                'RecoveryArea' => html_entity_decode($recoveryArea),
                'RecoverySince' => $recoverySince,
                'SpiritualGifts' => html_entity_decode($spiritualGifts)
            );
            array_push($people_arr['data'], $people_item);
        }
        // Push to "data"
        echo json_encode($people_arr);
    }else{
        $people_arr = array();
        $people_arr['data'] = array();
        $people_item = array('message' => 'No GROUPS defined');
        array_push($people_arr['data'], $people_item);
        
        echo  json_encode($people_arr);
    }
}




?>