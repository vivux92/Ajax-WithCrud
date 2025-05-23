<?php 
require_once "conn.php";
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $id  = $_POST['id'] ?? '';
    $sql = "DELETE FROM user_list_2 WHERE id='$id'";

    // echo "<pre>";
    // print_r($sql);
    // exit(' CALL');

    if(mysqli_query($con,$sql)){
        $response = ['status' => 1, 'msg' => 'data deleted successfully'];
    }else{
        $response = ['status' => 0, 'msg' => 'data cannont delete'];
    }

    echo json_encode($response);
    exit;
}
?>