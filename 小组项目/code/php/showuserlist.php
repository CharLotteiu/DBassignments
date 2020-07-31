<?php
//Created by 苏珊，显示用户列表界面
include ('conn.php');
?>
<!doctype html>
<html lang="zh">

<head>
	<title>MyTodo - 用户清单</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="../assets/vendor/linearicons/style.css">
	<link rel="stylesheet" href="../assets/vendor/chartist/css/chartist-custom.css">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="../assets/css/main.css">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
	<!-- Layui -->
	<link rel="stylesheet" href="../layui/css/layui.css"  media="all">

</head>

<body>

<div class="col-md-4">
<!-- BASIC TABLE -->
<div class="panel">
	<div class="panel-heading">
		<h3 class="panel-title">用户清单列表</h3>
	</div>
	<div class="panel-body">
		<?php							
		$uid=$_GET['id'];
		$query = "select * from list where uid ={$uid}";
		$result = mysqli_query($conn,$query) or die('Query failed: ' . mysqli_error($conn));;

		if(mysqli_num_rows($result)==0) // Edited by 苏珊，判断 mysqli_query 结果，值为0时表明语句成功执行，但是查询结果为空。
		{
			echo "该用户未添加其他清单。";
		}
		else{
			echo "<table class='table'>
						<thead>
							<tr>
								<th>#</th>
								<th>清单名称</th>
							</tr>
						</thead>";
			
			function result2Arr($result){
				while($result_row = mysqli_fetch_assoc($result)){
				$arr[] = $result_row;
				}
				return $arr;
			}
			$arr = result2Arr($result);

			foreach($arr as $key=>$value){
				echo "<tbody><tr>";
				echo "<td>".$value['uid']."</td>";
				echo "<td>".$value['list_name']."</td>";								
				echo "</tr></tbody>";
			}
			echo "</table>";			
		}
		?>				
		<p><button type='button'class='btn btn-default' onclick='window.close();'>关闭</button></p>				
	</div>
</div>
<!-- END BASIC TABLE -->
</div>
</body>
</html>