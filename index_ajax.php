<?php
require_once "conn.php";
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $sql = "SELECT * FROM user_list_2";
    $result = mysqli_query($con, $sql);

    if(mysqli_num_rows($result) > 0){
        $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
        $response = ['status' => 1, 'data' => $data];
    }else{
        $response = ['status' => 0, 'data' => []];
    }

    echo json_encode($response);
    exit;
}
