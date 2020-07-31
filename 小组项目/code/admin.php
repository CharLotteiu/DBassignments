<?php 
//Created by 苏珊，用户管理界面

session_start();
if (!isset($_SESSION['login'])) //未登录
{
    header('Location:login.php');
}
else
{       
    if($_SESSION['status']!=0) //非管理员访问
    {
		echo "<script>alert('抱歉,您没有访问权限！');parent.location.href='login.php';</script>";
	}
}
?>

<!doctype html>
<html lang="zh">

<head>
	<title>MyTodo - 管理</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/vendor/linearicons/style.css">
	<link rel="stylesheet" href="assets/vendor/chartist/css/chartist-custom.css">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="assets/css/main.css">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
	<!-- Layui -->
	<link rel="stylesheet" href="layui/css/layui.css"  media="all">
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="brand">
                <!-- MyTodo LOGO -->
				<a href="#"><img width="100" height="25" src="assets/img/logo-dark.png" alt="Klorofil Logo" class="img-responsive logo"></a>
			</div>
			<div class="container-fluid">
				<div class="navbar-btn">
					<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
                </div>
                <!-- 搜索框 -->
				<form class="navbar-form navbar-left" method ="POST" action="admin.php">
					<div class="input-group">
						<input type="text" value="" class="form-control" placeholder="查询用户信息" name="searchword">
						<span class="input-group-btn"><button type="submit" class="btn btn-primary">Go</button></span>
					</div>
				</form>
				<div id="navbar-menu">
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span><?php echo $_SESSION['username'];?></span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu">
								<li><a href="login.php?action=logout"><i class="lnr lnr-exit"></i> <span>用户登出</span></a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<!-- END NAVBAR -->
		<!-- LEFT SIDEBAR -->
		<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
						<li><a href="#" class="active"><i class="lnr lnr-home"></i> <span>用户信息</span></a></li>
					</ul>
				</nav>
			</div>
		</div>
		<!-- END LEFT SIDEBAR -->
		<!-- MAIN -->
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
                    <div class="row">
						<div class="col-md-8">    
							<!-- TABLE STRIPED -->
							<div class="panel">
								<div class="panel-heading">
									<?php
										$weekarray = array("日","一","二","三","四","五","六");
										echo '<h1>Hi, '.$_SESSION['username'].'<br></h1>
											<p class="lead">'.date("Y年n月j日").' 星期'.$weekarray[date("w",strtotime(date("Y-m-d")))].'</p>';
									?>
									<div class="right">
                                        <button title="return" type="button" class="btn-lg"><a href="admin.php"><i class="lnr lnr-magnifier"></i></a></button>
                                    </div>
                                </div>
								<div class="panel-body">	
									<?php

									//用户查询功能
									include ('php/conn.php');
									
									if(isset($_POST["searchword"])){
										$searchword =$_POST['searchword']; // 获取查询词
										echo"您查询的用户信息如下：";
										$query="select * from user where 
											user_name LIKE '%$searchword%'";
									}
									else
									{
										$query="select * from user";
									}
									
									echo "<table class='table table-striped'>
												<thead>
													<tr>
														<th>#</th>
														<th>用户名</th>
														<th>权限</th>
														<th>邮箱</th>
														<th>清单列表</th>
														<th>删除用户</th>
													</tr>
												</thead>";

									$result = mysqli_query($conn,$query) or die('Query failed: ' . mysqli_error($conn));;
									if(mysqli_num_rows($result)==0)
									{
										echo "无相关用户。";}
									else{
									//该函数将数据库的数据写成数组形式
										while ($value = mysqli_fetch_array($result)){
											echo "<tbody><tr class='active'>";
											echo "<td>".$value['uid']."</td>";
											echo "<td>".$value['user_name']."</td>";								
											if ($value['role']==0)
												echo "<td>管理员</td>";
											else if ($value['role']==1)
												echo "<td>普通用户</td>";
											else echo "<td>权限不明</td>";
											echo "<td>".$value['email']."</td>";
											echo "<td><a href='php/showuserlist.php?id=$value[uid]' target='_blank'><button type='button' class='btn btn-info' onclick='ShowList($value[uid])'><i class='fa fa-info-circle'></i></button></a></td>";
											echo "<td><a href='php/deleteuser.php?id=$value[uid]'><button type='button' class='btn btn-danger'><i class='fa fa-trash-o'></i></button></a></td>";
											
										echo "</tr></tbody>";
										}
									}
									?>
									</table>
								</div>
							</div>
							<!-- END TABLE STRIPED -->
                        </div>
                        <div class="col-md-4"> 
                            <!-- INPUTS -->
                            <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title">添加用户</h3>
                                    <div class="right">
                                        <button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
                                        <button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
                                    </div>
                                </div>
								<form method="post" action="php/adduser.php">
                                <div class="panel-body">
                                    <input type="text" class="form-control" placeholder="用户名" name="username"><br/>
									<input type="text" class="form-control" placeholder="邮箱" name="email" required><br/>
                                    <input type="password" class="form-control" value="asecret" name="password" required><br/>                                  
                                    <select class="form-control" name="type">
                                        <option value="1">普通用户</option>
										<option value="0">管理员</option>
                                    </select>
									<br>
									<button type="submit" class="btn btn-default">添加 </button>
                                </div>
								</form>
                            </div>
                            <!-- END INPUTS -->
                        </div>
                    </div>      
				</div>
			</div>
            <!-- END MAIN CONTENT -->
		</div>
        <!-- END MAIN -->
		<div class="clearfix"></div>
		<footer>
			<div class="container-fluid">
				<p class="copyright">Copyright &copy; 2020. MyTodo Mgt System All rights reserved.</p>
				
			</div>
		</footer>
	</div>
	<!-- END WRAPPER -->
	<!-- Javascript -->
	<script src="assets/vendor/jquery/jquery.min.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
	<script src="assets/vendor/chartist/js/chartist.min.js"></script>
	<script src="assets/scripts/klorofil-common.js"></script>
	<script src="layui/layui.js" charset="utf-8"></script>
	<script> 
	</script>
</body>
</html>
