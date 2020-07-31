<?php
//Created by 张晓彤
include('conn.php');
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$user_sql = "select * from user where email = '{$email}'";
$user_result = mysqli_query($conn,$user_sql);
if($row = mysqli_fetch_array($user_result,MYSQLI_ASSOC)){
    mysqli_close($conn);
    $json_arr = array("user_status"=>1);
    echo json_encode($json_arr);
}else{
    $user_sql = "insert into user (user_name, password, email, role) values ('{$username}','{$password}','{$email}',1)";
    mysqli_query($conn,$user_sql);
    mysqli_close($conn);
    $json_arr = array("user_status"=>0);
    echo json_encode($json_arr);
}
?>