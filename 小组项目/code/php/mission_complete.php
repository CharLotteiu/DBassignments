<?php
//Created by 张晓彤
include('conn.php');
if ($_POST['status']==0||$_POST['status']==3){
    $status = 1;
}
else{
    $status = 0;
}
$tid = $_POST['tid'];
$update_sql="UPDATE todo SET status='{$status}' WHERE tid='{$tid}'";
mysqli_query($conn,$update_sql)or die(mysqli_error($conn));
mysqli_close($conn);

?>