<?php

//header("Content-Type: text/html; charset=utf-8");
$conn = mysqli_connect("localhost", "root", "168168") or die("连接数据库失败" . mysqli_error($conn));
mysqli_select_db($conn, "todolist") or die("选择数据库失败" . mysqli_error($conn));
mysqli_query($conn, "set names utf8");

?>



