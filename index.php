<?php

if(isset($_GET["limit"])){
    $limit = $_GET["limit"];
}else{
    $limit = 3;
}
if(isset($_GET["order"])){
    $order = $_GET["order"];
}else{
    $order = "ASC";
}
if(isset($_GET["start"])){
    $start = $_GET["start"] - 1;
}else{
    $start = 0;
}


$servername = "localhost";
$username = "id14786519_ayomadewale";
$password = "Qwerty@1234@";
$db = "id14786519_stackjobs";
$conn = new mysqli($servername,$username,$password,$db);

if($conn->connect_error){
    die("Hello, Couldn't connect to database");
}

if(isset($limit)|| isset($order) || isset($start)){
    
$q = "SELECT * FROM jobs ORDER BY id $order LIMIT $limit OFFSET $start";
$rsp = $conn->query($q);


$jobs = [];


if ($rsp->num_rows > 0) {
    // output data of each row
    while($row = $rsp->fetch_assoc()) {
      array_push($jobs,$row);
    }
  }



echo json_encode($jobs);

}










?>