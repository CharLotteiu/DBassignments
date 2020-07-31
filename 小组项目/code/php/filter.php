<?php
include ('conn.php');

//Created by 苏珊，筛选TODO 
//用userid确认是否提交了查询信息
if(isset($_POST['userid'])){ 
    $uid = $_POST['userid'];
    $content = $_POST['content'];
    $enddate = $_POST['enddate'];
    $list = $_POST['list'];
    $importance = $_POST['imporate'];
	$status = $_POST['status'];
	
	$select = "SELECT todo.tid, todo.content, todo.ddl, todo.importance, todo.status, list.list_name 
				 FROM todo 
				 LEFT JOIN list 
				 ON todo.lid = list.lid";
	
	$list_sql ='';
	$where = [];
	
	if($list!=''){
		$list_sql = " AND list.list_name LIKE '%$list%'"; //模糊匹配清单名称
	}
	if($uid!=''){
		$where[] = "todo.uid = '$uid'";
	}	
	if($content!=''){
		$where[] = "todo.content LIKE '%$content%'"; //模糊匹配内容
	}
	if($enddate!=''){
		$where[] = "todo.ddl >= '$enddate'"; //截至日期之前
	}
	if($importance!=''){
		$where[] = "todo.importance = '$importance'";
	}
	if($status!=''){
		$where[] = "todo.status = '$status'";
	}
	
	//根据获取到的筛选条件数量拼合SQL语句
	$todo_sql = $select.$list_sql."
				WHERE ".implode(" AND ", $where)." 
			    AND todo.ddl >= CURDATE()
				ORDER BY todo.status asc, todo.ddl asc";	
	//echo $todo_sql;	
	
}
else{
	$todo_sql = 'SELECT todo.tid, todo.content, todo.ddl, todo.importance, todo.status, list.list_name 
				 FROM todo 
				 LEFT JOIN list 
				 ON todo.lid=list.lid 
	WHERE todo.uid ="'.$_SESSION['userid'].'" and todo.ddl >= CURDATE() ORDER BY todo.status asc, todo.ddl asc';
}

//Created by 张晓彤 Edited by 刘玲玲
$ii = 0;
$todo_result = mysqli_query($conn,$todo_sql) or die(mysqli_error($conn));

if(mysqli_num_rows($todo_result)==0) // Edited by 苏珊，判断 mysqli_query 结果，值为 0 时表明语句成功执行，但是查询结果为空。
{
    echo "似乎暂时没有需要关注的任务哦，去添加几条吧~";}
else{
	while($row = mysqli_fetch_array($todo_result,MYSQLI_ASSOC)){
        if($row['list_name']==NULL){
            $row['list_name']='';
        }
        else{
            $row['list_name']=$row['list_name'].' | ';
        }

		if($row['status']==1){
			echo '<li class="completed" id="'.$ii.'"><label class="control-inline fancy-checkbox">
			<input type="checkbox" id="'.$ii.'_sel" onClick="status_toggle('.$ii.','.$row['tid'].','.$row['status'].')" checked="checked">'.'<span></span>
			</label>
			<p>
				<a href="javascript:void(0);" style="color:gray" onClick="EditTodo('.$row['tid'].');"><span class="title" style="margin-right:5px">'.$row['list_name'].$row['content']."   </span><span class='label label-success'>已完成</span>
				<span class='short-description'><span class='star_rate'></span><input class='impo' type='hidden' value='".$row['importance']."'></input>";
		}
		else{
			echo '<li id="'.$ii.'"><label class="control-inline fancy-checkbox">
			<input type="checkbox" id="'.$ii.'_sel" onClick="status_toggle('.$ii.','.$row['tid'].','.$row['status'].')">'.'<span></span>
			</label>
			<p>
				<a href="javascript:void(0);" onClick="EditTodo('.$row['tid'].');"><span class="title" style="margin-right:5px">'.$row['list_name'].$row['content']." </span></a><span class='label label-warning'>进行中</span>
				<span class='short-description'><span class='star_rate'></span><input class='impo' type='hidden' value='".$row['importance']."'></input>";
		}

	$ii++;

	$weekarray=array("日","一","二","三","四","五","六");
	echo '</span>
		<span class="date">'.$row['ddl'].' '.'星期'.$weekarray[date("w",strtotime($row['ddl']))].'</span>
		</p>
		<div class="controls">
		<button type="button" class="btn btn-danger" onclick="DelTodo('.$row['tid'].')"><i class="fa fa-trash-o"></i></button></li>';
	}
}	

mysqli_close($conn);

?>