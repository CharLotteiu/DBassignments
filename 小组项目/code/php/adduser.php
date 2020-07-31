<?php
//Created by 苏珊，管理员新增用户
include ('conn.php');
$sql="insert into user (user_name,email,password,role) value('{$_POST['username']}','{$_POST['email']}','{$_POST['password']}','{$_POST['type']}')"; 

if(mysqli_query($conn,$sql))
{
	header("location:../admin.php");
}
else
{
	echo "<script>alert('新增失败！')</script>";
}

?>