<?php 
require_once "conn.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $id            = $_POST['id'] ?? '';
    $first_name    = $_POST['first_name'] ?? '';
    $last_name     = $_POST['last_name'] ?? '';
    $email         = $_POST['email'] ?? '';
    $gender        = $_POST['gender'] ?? '';
    $old_img       = $_POST['old_img'] ?? '';

    $image = $old_img;
    if (isset($_FILES['image']) && $_FILES['image']['name']) {
        // echo "<pre>";
        // print_r('in');   
        // exit(' CALL');
        $file_name = $_FILES['image']['name'];
        $file_tmp  = $_FILES['image']['tmp_name'];

        $uploads = move_uploaded_file($file_tmp, "profile-img/" . $file_name);

        $image = $file_name ?? '';
    }
    // echo "<pre>";
    // print_r($image);
    // exit(' CALL');

    $sql = "UPDATE user_list_2 SET first_name='$first_name',last_name='$last_name',email='$email',gender='$gender',file_name='$image' WHERE id='$id'";
    //  echo "<pre>";
    //  print_r($sql);
    //  exit(' CALL');
    if(mysqli_query($con,$sql)){
        $response = ['status' => 1, 'msg' => 'data update successfully'];
    }else{
        $respomse = ['status' => 0, 'msg' => 'data cannot update'];
    }

    echo json_encode($response);
    exit;
}
?>