<?php
require_once "conn.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $first_name    = $_POST['first_name'] ?? '';
    $last_name     = $_POST['last_name'] ?? '';
    $email         = $_POST['email'] ?? '';
    $password      = $_POST['password'] ?? '';
    $gender        = $_POST['gender'] ?? '';
    $password_hash = password_hash($password, PASSWORD_DEFAULT);


    if (isset($_FILES['image']) && $_FILES['image']['name']) {

        $file_name = $_FILES['image']['name'];
        $file_tmp  = $_FILES['image']['tmp_name'];

        $uploads = move_uploaded_file($file_tmp, "profile-img/" . $file_name);
    }
    // echo "<pre>";
    // print_r($_FILES);
    // exit(' CALL');
    $sql = "INSERT INTO user_list_2 (first_name,last_name,email,password,gender,file_name) 
    VALUES ('$first_name','$last_name','$email','$password_hash','$gender','$file_name')";

    if (mysqli_query($con, $sql)) {
        $response = ['status' => 1, 'msg' => 'data saved successfully'];
    } else {
        $response = ['status' => 0, 'msg' => 'data cannot save '];
    }

    echo json_encode($response);
    exit;
}
