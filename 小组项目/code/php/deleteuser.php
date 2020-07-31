<?php
//Created by 苏珊，删除用户
include ('conn.php');
							
$uid=$_GET['id'];
$sql_delete_term="delete from user where uid ={$uid}";

if(mysqli_query($conn,$sql_delete_term))
{
	header("location:../admin.php");
}
else
{
	echo "<script>alert('删除失败！')</script>";
}
?>