<?php
/*created by 崔冰*/
//header('Content-Type: application/json; charset=utf-8');
include ('conn.php');
$lid = $_POST['listid'];

//先删除todo再删除list
$todo_del_sql = "DELETE FROM todo WHERE lid='{$lid}'";
if(mysqli_query($conn,$todo_del_sql)){
    $result = '删除成功';
}
else{
    $result = mysqli_error($conn);
}

$list_del_sql = "DELETE FROM list WHERE lid='{$lid}'";

if(mysqli_query($conn,$list_del_sql)){
    $result = '删除成功';
}
else{
    $result = mysqli_error($conn);
}

echo json_encode($result);

mysqli_close($conn);
?>