<?php
/*Create by 崔冰*/
header("Content-Type: text/html; charset=utf-8");       //此行是为了防止乱码
if (!isset($_POST['addlist'] )) {
    exit('非法访问!');
}
else
{

//包含数据库连接文件
	include ('conn.php');
	session_start();
	if (isset($_POST['addlist']))
		{
			$newlist = $_POST['addl'];
			$username =  $_SESSION['username'];
			$userid = $_SESSION['userid'];
			
				//先判断清单是否已存在
				$sql_search='SELECT lid from list WHERE list_name="'.$newlist.'" and uid="'.$userid.'"';
				$search_result = mysqli_query($conn,$sql_search)or die(mysqli_error($conn));
				$search_query = mysqli_fetch_array($search_result,MYSQLI_ASSOC);
				if(!$search_query){
					$sql="INSERT INTO list (uid, list_name)
					VALUES
					('$userid','$newlist')";
					
					if (!mysqli_query($conn,$sql))
					  {
					  die('Error: ' . mysqli_error($conn));
					  }
					else{
						header('Location:../index.php');
						
					}
				}
				else{
					
					echo "<script type='text/javascript'>
					alert('清单已存在！');
					window.location.href = '../index.php';
					</script>"; 
				}		
				
				
				
			}
			
			
}

?>