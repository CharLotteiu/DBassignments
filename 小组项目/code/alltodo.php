<?php session_start();?>
<?php
if (!isset($_SESSION['login'])) //未登录
{
    header('Location:login.php');
}
else
{       
    if($_SESSION['status']!=1) //非用户访问
    {
		echo "<script>alert('抱歉,您没有访问权限！');parent.location.href='login.php';</script>";
	}
}
?>

<!doctype html>
<html lang="zh">

<head>
	<title>MyTodo - 全部任务</title>
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
				<a href="index.html"><img width="100" height="25" src="assets/img/logo-dark.png" alt="Klorofil Logo" class="img-responsive logo"></a>
			</div>
			<div class="container-fluid">
				<div class="navbar-btn">
					<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
                </div>
                <!-- 搜索框 -->
				<form class="navbar-form navbar-left" method="get" action="searchresult.php">
					<div class="input-group">
						<input name="todoname" type="text" value="" class="form-control" placeholder="想搜点什么呢？">
						<span class="input-group-btn"><button type="submit" class="btn btn-primary">Go</button></span>
					</div>
				</form>
				<div id="navbar-menu">
					<ul class="nav navbar-nav navbar-right">
                    <!-- 过期任务提醒 -->    
                    <li class="dropdown">
							<a href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown">
								<i class="lnr lnr-alarm"></i>
								<?php
									//Created by 刘玲玲
									include('php/conn.php');
									$result=[];
									$ddl_sql = 'SELECT content, ddl, status FROM todo WHERE uid='.$_SESSION['userid'];
									$ddl_result = mysqli_query($conn,$ddl_sql) or die(mysqli_error($conn));
									while($row = mysqli_fetch_array($ddl_result,MYSQLI_ASSOC)){
										if($row['ddl']==date('Y-m-d',strtotime("-1 day"))&&$row['status']==0){
											$li = '<li><a href="#" class="notification-item"><span class="dot bg-warning"></span>'.$row['content'].'</a></li>';
											array_push($result,$li);
										}
										else if($row['ddl']==date('Y-m-d',strtotime("-2 day"))&&$row['status']==0){
											$li = '<li><a href="#" class="notification-item"><span class="dot bg-danger"></span>'.$row['content'].'</a></li>';
											array_push($result,$li);
										}
									}

								?>
								<span class="badge bg-danger"><?php echo sizeof($result);?></span>
							</a>
							<ul class="dropdown-menu notifications">
								<?php
									//Created by 刘玲玲
									foreach($result as $r){
										echo $r;
									}
								?>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span><?php echo $_SESSION['username'];?></span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu">
								<!--<li><a href="#"><i class="lnr lnr-cog"></i> <span>Settings</span></a></li>-->
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
						<li><a href="index.php" class=""><i class="lnr lnr-home"></i> <span>我的一天</span></a></li>
						<li><a href="alltodo.php" class="active"><i class="lnr lnr-dice"></i> <span></span>全部任务</a></li>
						<li>
							<a href="#subPages" data-toggle="collapse" class="collapsed"><i class="lnr lnr-menu"></i> <span>清单列表</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="subPages" class="collapse ">
								<ul class="nav" id="navlists">
									<?php
										include('list.php');
									?>
							</div>
						</li>
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
						<div class="col-md-8" id="todo">    
                            <!-- TODO LIST -->
                            <div class="panel" id="todolist">
                                <div class="panel-heading">
                                    <h3 class="panel-title">全部 TO-DO</h3>
									<div class="right">
                                        <button title="新增To-Do" type="button" class="btn-lg" onClick="NewTodo();"><i class="lnr lnr-plus-circle"></i></button>
                                        <button title="筛选To-Do" type="button" class="btn-lg"><a href="alltodo.php"><i class="lnr lnr-magnifier"></i></a></button>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <ul class="list-unstyled todo-list">
									<?php
											// Created by 苏珊，筛选TODO 
											// 用userid确认是否提交了查询信息
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
													$list_sql = " AND list.list_name LIKE '%$list%'";
												}
												if($uid!=''){
													$where[] = "todo.uid = '$uid'";
												}	
												if($content!=''){
													$where[] = "todo.content LIKE '%$content%'";
												}
												if($enddate!=''){
													$where[] = "todo.ddl >= '$enddate'";
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
															ORDER BY todo.status asc, todo.ddl asc";	
												//echo $todo_sql;	
												
											}
											//Created by 张晓彤
											//Edited by 刘玲玲
											else{
												$todo_sql = 'SELECT todo.tid, todo.content, todo.ddl, todo.importance, todo.status, list.list_name 
															 FROM todo 
															 LEFT JOIN list 
															 ON todo.lid=list.lid 
															 WHERE todo.uid ="'.$_SESSION['userid'].'"ORDER BY todo.status asc, todo.ddl asc';
											}											

											$ii = 0;
											$todo_result = mysqli_query($conn,$todo_sql) or die(mysqli_error($conn));
											if(mysqli_num_rows($todo_result)==0){
                                                echo "似乎暂时没有需要关注的todo哦，去添加几条吧~";
											}
											else{
												while($row = mysqli_fetch_array($todo_result,MYSQLI_ASSOC)){
													if($row['ddl']<date('Y-m-d')&&$row['status']==0){
														$row['status']=3;
													}

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
													else if($row['status']==0){
														echo '<li id="'.$ii.'"><label class="control-inline fancy-checkbox">
														<input type="checkbox" id="'.$ii.'_sel" onClick="status_toggle('.$ii.','.$row['tid'].','.$row['status'].')">'.'<span></span>
														</label>
														<p>
															<a href="javascript:void(0);" onClick="EditTodo('.$row['tid'].');"><span class="title" style="margin-right:5px">'.$row['list_name'].$row['content']." </span></a><span class='label label-warning'>进行中</span>
															<span class='short-description'><span class='star_rate'></span><input class='impo' type='hidden' value='".$row['importance']."'></input>";
													}
													else{
														echo '<li id="'.$ii.'"><label class="control-inline fancy-checkbox">
														<input type="checkbox" id="'.$ii.'_sel" onClick="status_toggle('.$ii.','.$row['tid'].','.$row['status'].')">'.'<span></span>
														</label>
														<p>
															<a href="javascript:void(0);" onClick="EditTodo('.$row['tid'].');"><span class="title" style="margin-right:5px">'.$row['list_name'].$row['content']." </span></a><span class='label label-danger'>已过期</span>
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
                                    </ul>
                                </div>
                            </div>
                            <!-- END TODO LIST -->
                        </div>
                        <div class="col-md-4" id="leftspace"> 
							<!-- TODO Filter -->
							<!-- Created by 苏珊，筛选功能显示 -->
                            <div class="panel" id="newtodo">
                                <div class="panel-heading">
                                    <h3 class="panel-title">筛选 TO-DO</h3>
                                </div>
                                <div class="panel-body">
									<form method="POST" action="##">
										<div class="form-group">
											<label for="content">内容</label>
											<div class="input-group">
												<span class="input-group-addon"><i class="lnr lnr-pencil"></i></span>
												<input name="content" id="content" name="content" type="text" class="form-control" placeholder="请输入关键字">
											</div>
										</div>
										<div class="form-group">
											<label style="display:block" for="importance">重要性</label>
											<div id="importance"></div>
											<input type="hidden" id="imporate" name="imporate" value="">
										</div>
										<div class="form-group">
											<label for="calendar">截止日期</label>
											<div class="input-group">
												<span class="input-group-addon"><i class="lnr lnr-calendar-full"></i></span>
												<input name="enddate" id="calendar" type="text" class="form-control" value="">
											</div>
										</div>
										<div class="form-group">
											<label for="list">清单分类</label>
											<div class="input-group">
												<span class="input-group-addon"><i class="lnr lnr-tag"></i></span>
												<input name="list" id="list" type="text" class="form-control" value="" list="listname">
												<datalist id="listname">
													<?php
													
														include ('conn.php');
														$tid = $_SESSION['userid'];
														$todo_sql = 'SELECT todo.content, todo.ddl, todo.importance, todo.status, list.list_name FROM todo LEFT JOIN list ON todo.lid=list.lid WHERE tid='.$tid;
														$todo_result = mysqli_query($conn,$todo_sql);
														$todo_query = mysqli_fetch_array($todo_result,MYSQLI_ASSOC);
														// 加载已有清单列表，方便用户选择
														foreach($list_names as $list_name){
																echo '<option value="'.$list_name['list_name'].'">'.$list_name['list_name'].'</option>';
														}
													?>
												</datalist>
											</div>
										</div>
										<div class="form-group">
											<label style="display:block" for="status">状态</label>
											<select class="form-control" name="status">
												<option value="0"><span type="radio" id='status' class='label label-warning'>进行中</span></option>
												<option value="1"><span id='status' class='label label-success'>已完成</span></option>
												<option value="2"><span id='status' class='label label-danger'>已逾期</span></option>
											</select>
											</div>
										</div>
										<div class="form-group">
											<input type="hidden" id="userid" name="userid" value="<?php echo $_SESSION['userid']?>">
										</div>
										<div class="form-group">
											<button style="display:block;margin:0 auto" type="submit" class="btn btn-info">提交</button>
										</div>
									</form>
                                </div>
                            </div>
							<!-- END TODO Filter -->
							</div>							
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
	
	//页面loading的时候就执行的语句
	$(function(){
		//Created by 刘玲玲

		//给新增TODO页面渲染日历和评分组件
		layui.use(['laydate','rate'], function(){
			var laydate = layui.laydate;
			var rate = layui.rate;

			laydate.render({
				elem: '#calendar'
				,theme: '#1E9FFF'
			});

			rate.render({
				elem: '#importance'
				,length:3
				,choose:function(value){
					$("#imporate").attr("value",value);
				}
			});
		})
		
		//给TODO List渲染重要性评分组件
		xuanranrate();

	});
	
	//给TODO List渲染重要性评分组件函数
	//Created by 刘玲玲
	function xuanranrate(){
		layui.use('rate', function(){
			$('#todolist').find('.short-description').each(function(){
				var imposcore=$(this).children('.impo').val();
				var rate = layui.rate;
				
				rate.render({
					elem:$(this).children('.star_rate')
					,length:3
					,value:imposcore
					,readonly:true
				});
			});
		});
	}

	//调出编辑页面的函数
	//Created by 刘玲玲
	function EditTodo(todoid){
		var tid=todoid;
		var listhtml='';
		$('#navlists').each(function(){
			$(this).find('li').each(function(){
				listhtml=listhtml+'<option value="'+$(this).text()+'">'+$(this).text()+'</option>';
			});
		});

		$("#leftspace").load('php/edittodo.php #edittodo', {'id':tid}, function( response, status, xhr ) {
					if ( status == "error" ) {
						var msg = "对不起，有一个错误: ";
						$( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
					}
					var importance = $(response).find('#imporate').val();

					layui.use(['laydate','rate'], function(){
						var laydate = layui.laydate;
						var rate = layui.rate;

						laydate.render({
							elem: '#calendar'
							,theme: '#1E9FFF'
						});
						rate.render({
							elem: '#importance'
							,length:3
							,value:importance
							,setText: function(value){ //自定义文本的回调
								var arrs = {
									'1': '不太重要'
									,'2': '比较重要'
									,'3': '非常重要'
								};
								this.span.text(arrs[value] || ( value + "星"));
							}
							,choose:function(value){
								$("#imporate").attr("value",value);
							}
						});
					});
				});
	}

	//修改TODO后提交函数
	//Created by 刘玲玲
	function submit() {
			var edittodo = $('#editform').serialize()+'&todoid='+$('#todoid').val()+'&userid='+$('#userid').val();

            $.ajax({
            //几个参数需要注意一下
                type: "POST",//方法类型
                dataType: "json",//预期服务器返回的数据类型
                url: "php/updatetodo.php" ,//url
                data: edittodo,
                success: function (result) {
					layui.use('layer', function(){
						var layer = layui.layer;
						
						layer.alert('修改成功', {
							title: '温馨提示'
							,skin: 'layui-layer-lan'
							,closeBtn: 1
						}, function(){
							window.location.reload();
						});
					});             
                },
                error : function(date, type, err) {
					//alert("异常！");
					console.log("ajax错误类型："+type);
	         		console.log(err);
                }
            });
	}
	
	//删除Todo时调用的函数
	//Created by 刘玲玲
	function DelTodo(todoid){
		var tid=todoid;

		layui.use('layer',function(){
			layer.confirm('确认要删除这个 To-Do 吗？', {
				title: '删除 To-Do'
				,skin: 'layui-layer-lan'
				,btn: ['十分肯定','再想一下'] //按钮
				}, function(){
					$.ajax({

							type: "POST",//方法类型
							dataType: "json",//预期服务器返回的数据类型
							url: "php/deletetodo.php" ,//url
							data: "todoid="+tid,
							success: function (result) {
								layer.msg(result);
								window.location.reload();
							},
							error : function(date, type, err) {
								//alert("异常！");
								console.log("ajax错误类型："+type);
								console.log(err);
							}
					})
				});
			});
	}

	//删除清单
	function DelList(listid){
		var lid=listid;

		layui.use('layer',function(){
			layer.confirm('确认要删除这个清单以及清单内的全部To-Do吗？', {
				title: '删除 清单'
				,skin: 'layui-layer-lan'
				,btn: ['十分肯定','再想一下'] //按钮
				}, function(){
					$.ajax({
						type: "POST",//方法类型
						dataType: "json",//预期服务器返回的数据类型
						url: "php/delete_list.php" ,//url
						data: "listid="+lid,
						success: function (result) {
							layer.msg(result);
							window.location.reload();
						},
						error : function(date, type, err) {
							//alert("异常！");
							console.log("ajax错误类型："+type);
							console.log(err);
						}
					})
				});
			});
	}

	//新建清单  
	//Created by 崔冰
	layui.use(['layer','form'],function(){
	    var form=layui.form;
	    var layer=layui.layer;
	    $=layui.jquery;

		$("#add").on('click',function(){
	          layer.open({
	              type:1,
	              title:"新增清单",
	              skin:'layui-layer-lan',
	              area:["400px","300px"],
	              content:$("#test").html(),
	              success: function(layero, index){},
	              yes:function(){}
	          });
		          form.render();//动态渲染
		}); 

		form.verify({
			    questionnaireName: function(value){
			  if(value.length < 1){        
			      return '清单名称不得为空';    
			      }        
			  }     
		});     
 	});  
	
	//调出新增页面的函数
	//Edited by 苏珊
	function NewTodo(){
		var listhtml='';
		$('#navlists').each(function(){
			$(this).find('li').each(function(){
				listhtml=listhtml+'<option value="'+$(this).text()+'">'+$(this).text()+'</option>';
			});
		});

		$("#leftspace").load('php/addtodo.php #newtodo', function( response, status, xhr ) {
					if ( status == "error" ) {
						var msg = "对不起，有一个错误: ";
						$( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
					}
					var importance = $(response).find('#imporate').val();

					layui.use(['laydate','rate'], function(){
						var laydate = layui.laydate;
						var rate = layui.rate;

						laydate.render({
							elem: '#calendar'
							,theme: '#1E9FFF'
						});
						rate.render({
							elem: '#importance'
							,length:3
							,value:importance
							,setText: function(value){ //自定义文本的回调
								var arrs = {
									'1': '不太重要'
									,'2': '比较重要'
									,'3': '非常重要'
								};
								this.span.text(arrs[value] || ( value + "星"));
							}
							,choose:function(value){
								$("#imporate").attr("value",value);
							}
						});
					});
				});
	}

    //新增TODO后调用该函数提交数据
	//Edited by 苏珊
	function submitnew() {
			var newtodo = $('#editform').serialize();
            $.ajax({
            //几个参数需要注意一下
                type: "POST",//方法类型
                dataType: "json",//预期服务器返回的数据类型
                url: "php/add_todo.php" ,//url
                data: newtodo,
                success: function (result) {
					layui.use('layer', function(){
						var layer = layui.layer;
						
						layer.alert('新建成功', {
							title: '温馨提示'
							,skin: 'layui-layer-lan'
							,closeBtn: 1
						}, function(){
							window.location.reload();
						});
					});             
                },
                error : function(date, type, err) {
					//alert("异常！");
					console.log("ajax错误类型："+type);
	         		console.log(err);
                }
            });
	}

	//标注任务已完成函数
	//Created by 张晓彤
	//Edited by 刘玲玲
	function status_toggle(ele_id,tid, status){
        $.ajax({
            url:"php/mission_complete.php",           //the page containing php script
            type: "POST",               //request type
            data:{tid: tid,status: status},
            success:function(result){
                if (status==0){
                    $("#"+ele_id+"_sel").removeAttr("onclick");
					$("#"+ele_id+"_sel").attr("onclick","status_toggle("+ele_id+","+tid+",1);");
                }else {
                    $("#"+ele_id+"_sel").removeAttr("onclick");
                    $("#"+ele_id+"_sel").attr("onclick","status_toggle("+ele_id+","+tid+",0);");
				}
				$( "#todo" ).load( "alltodo.php #todolist", function( response, status, xhr ) {
					if ( status == "error" ) {
						var msg = "对不起，但是有一个错误: ";
						$( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
					}
					xuanranrate();
				});
            }
        });
	}
	</script>
</body>

</html>
