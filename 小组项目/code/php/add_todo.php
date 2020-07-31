<?php
//Create by 崔冰 
//Edited by 苏珊 修改传入参数
include ('conn.php');
	
$new_content = $_POST['content'];
$new_imp = $_POST['imporate'];
$new_list = $_POST['list'];
$new_ddl = $_POST['enddate'];
$new_create = date('Y-m-d');
$uid = $_POST['userid'];

if($new_list=='')//如果不属于任何清单
{	
	$sql="INSERT INTO todo ( uid, ddl, create_date, content, importance,  status)
	VALUES
	(
	'$uid',
	'$new_ddl',
	'$new_create',
	'$new_content',                
	'$new_imp',
	
	0)";
}
		   
		
else
{
	//根据list name查询出lid再插入数据
	$newlist_sql ='select lid from LIST where list_name="'.$new_list.'"';
	$newlist_result = mysqli_query($conn,$newlist_sql)or die (mysqli_error($conn));
	$lid = mysqli_fetch_array($newlist_result,MYSQLI_ASSOC);
	
	//先判断list是不是新增的
	if(!$lid){
		$sql="INSERT INTO list (uid, list_name)
		VALUES
		('$uid','$new_list')";
		
		$sql_result=mysqli_query($conn,$sql) or die (mysqli_error($conn));
		$lid_sql='select lid from LIST where list_name="'.$new_list.'"';
		$lid_result=mysqli_query($conn,$lid_sql) or die (mysqli_error($conn));
		$lid_query = mysqli_fetch_array($lid_result,MYSQLI_ASSOC);
		$lidd=$lid_query['lid'];
	}
	else{
		$lidd=$lid['lid'];
	}

	$sql="INSERT INTO todo ( uid, ddl,  create_date, content, importance, lid, status)
	VALUES
	(
	'$uid',
	'$new_ddl',
	'$new_create',
	'$new_content',                
	'$new_imp',
	'$lidd',
	0)";
}

if (mysqli_query($conn,$sql))
{
	$result['status']='succeeded';
}
else{
	$result['status']=mysqli_error($conn);
}

echo json_encode($result);

?>