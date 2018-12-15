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
include once './Group.php';

private $client;
if($_SERVER['REQUEST_METHOD'] == "GET"){
    $this-client = "UAT";
    handleGet();
    
} else if ($_SERVER['REQUEST_METHOD"'] == "POST"){
    echo "POST not implemented yet";
} else {
    //requested method (not GET or POST) is not supported
    http_response_code(405);
}

private function handleGet(){
    //instantiate and connect to database
    $database = new Database();
    $db = $database->connect($this->client);
    
    $group = new Group($db);
    
    $result = $group->getAll();
    // get row count
    $num = $result->rowCount();
    
    // check if Groups exist
    if ($num>0){
        // there are groups found, make array to hold data
        $groups_arr = array();
        $groups_arr['data'] = array();
        while($row=$resut->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $group_item = array(
                'id' => $id;
                'mtgId' => $mtgId;
                'gender' => $gender;
                'title' => $title;
                'facId' => $facId;
                'coFacId' => $coFacId;
                'attendance' => $attendance;
                'location' => $location;
                'notes' => html_entity_decode($notes);
                
            );
            array_push($groups_arr, $group_item);
        }
        // Push to "data"
        //array_push($posts_arr, $post_item);
        // array_push($posts_arr['data'], $post_item);
        echo json_encode($groups_arr);
    }else{
        echo  json_encode(array('message' => 'No Groups found'));
    }
}




?>