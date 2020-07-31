<?php
//Created by 刘玲玲
//Edited by 张晓彤
header("Content-Type: text/html; charset=utf-8");       //此行是为了防止乱码
if (!isset($_POST['bttlogin'])) {
    exit('非法访问!');
}
else
{

//包含数据库连接文件
	include ('conn.php');
	if (isset($_POST['bttlogin']))
		{
			$email = $_POST['email'];
			$password = $_POST['password'];
			$user_sql = 'select uid, user_name from USER where email="'.$email.'"';
			$userid_result = mysqli_query($conn,$user_sql);
			$userid_query = mysqli_fetch_array($userid_result,MYSQLI_ASSOC);
			if(!$userid_query) //if there's no such username in the database, jump to error page.
				{
                    //header("Location: ../errors/noaccount.html");
                    echo "该用户不存在";
				}
			else {
				$password_sql = 'select password from USER where uid="'.$userid_query['uid'].'"and password ="'.$password.'"';
				$password_result = mysqli_query($conn,$password_sql);
				$password_query = mysqli_fetch_array($password_result,MYSQLI_ASSOC);
				if(!$password_query){ //if the password is incorrect, jump to error page.
                    //header("Location: ../errors/passworderr.html");
                    echo "用户密码错误，请重试";
				}
				else {
					session_start();
					$role_sql = 'select role from USER where uid = "'.$userid_query['uid'].'"';
					$role_result = mysqli_query($conn,$role_sql);
					$role_query = mysqli_fetch_array($role_result,MYSQLI_ASSOC);
					$_SESSION['status'] = $role_query['role'];
					$_SESSION['username'] = $userid_query['user_name'];
					$_SESSION['userid'] = $userid_query['uid'];
					$_SESSION['login']='login';
					if(!$_SESSION['status'])
					{header('Location:../admin.php');}
					else
					{header('Location:../index.php');}
					exit ;
				}
			}
			
			
		}
	mysqli_close($conn);
}
?>