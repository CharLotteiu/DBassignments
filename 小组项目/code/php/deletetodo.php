<?php
//header('Content-Type: application/json; charset=utf-8');
include ('conn.php');
$tid = $_POST['todoid'];
//$tid=7;

$todo_del_sql = "DELETE FROM todo WHERE tid='{$tid}'";

if(mysqli_query($conn,$todo_del_sql)){
    $result = '删除成功';
}
else{
    $result = mysqli_error($conn);
}

echo json_encode($result);

mysqli_close($conn);
?>