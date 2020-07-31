<?php
//Created by 张晓彤
if (isset($_GET['action']))
{
	session_start();
	if($_GET['action']=="logout")
	{session_destroy();}
}
?>

<!doctype html>
<html lang="zh" class="fullscreen-bg">

<head>
	<title>MyTodo管理系统 - 登录</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/vendor/linearicons/style.css">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="assets/css/main.css">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle">
				<div class="auth-box ">
					<div class="left">
						<div class="content">
							<div class="header">
								<!-- 此处的img以后我们可以自己设计一个然后替换掉 -->
								<div class="logo text-center"><img src="assets/img/logo-dark.png" alt="Klorofil Logo"></div>
								<p class="lead">用户登录</p>
                            </div>
                            <!-- 下方action修改为对应的php页面连接 -->
                            <form class="form-auth-small" method="POST" action="php/login.php">
								<div class="form-group">
									<label for="signin-account" class="control-label sr-only">邮箱</label>
									<input type="text" class="form-control" name="email" id="signin-account" value="" placeholder="请输入邮箱">
								</div>
								<div class="form-group">
									<label for="signin-password" class="control-label sr-only">密码</label>
									<input type="password" class="form-control" name="password" id="signin-password" value="" placeholder="请输入密码">
								</div>
								<button type="submit" class="btn btn-primary btn-lg btn-block" name="bttlogin">即刻进入</button>
								<div class="bottom">
                                    <!-- 注册账号 -->
                                    <span class="helper-text"><i class="fa fa-lock"></i> <a href="#" data-toggle="modal" data-target="#myModal">注册帐号</a></span>
								</div>
							</form>
						</div>
					</div>
					<div class="right">
						<div class="overlay"></div>
						<div class="content text">
							<h1 class="heading">MyTodo 管理系统</h1>
							<p>让您的生活井井有条</p>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">注册帐号</h4>
                    </div>
                    <div class="modal-body">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="lnr lnr-user"></i></span>
                            <input class="form-control" placeholder="请输入用户名" type="text" id="reg_username">
                        </div>
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="lnr lnr-envelope"></i></span>
                            <input class="form-control" placeholder="请输入邮箱" type="text" id="reg_email">
                        </div>
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="lnr lnr-lock"></i></span>
                            <input class="form-control" placeholder="请输入密码" type="password" id="reg_password">
                        </div>
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="lnr lnr-redo"></i></span>
                            <input class="form-control" placeholder="请再次输入密码" type="password" id="reg_repassword">
                        </div>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="reg()">注册</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    </div>
                </div>
            </div>
        </div>
	</div>
	<!-- END WRAPPER -->
</body>

<script src="assets/vendor/jquery/jquery.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
<script>
    function reg(){
        if ($("#reg_username").val()!=""){
            if ($("#reg_email").val()!=""){
                if($("#reg_password").val()!=""){
                    if($("#reg_repassword").val()!=""){
                        if ($("#reg_password").val() == $("#reg_repassword").val()){
                            $.ajax({
                                url:"php/reg_complete.php",           //the page containing php script
                                type: "POST",               //request type
                                data:{username:$("#reg_username").val(),
                                        password: $("#reg_password").val(),
                                        email: $("#reg_email").val()},
                                success:function(data){
                                    data = $.parseJSON(data)
                                    if(data['user_status']==0){
                                        alert("注册成功！");
                                        $("#reg_username").val('');
                                        $("#reg_password").val('');
                                        $("#reg_repassword").val('');
                                        $("#reg_email").val('');
                                        $("#myModal").modal('hide');
                                    }else{
                                        alert("邮箱已占用！");
                                    }
                                }
                            });
                        }
                        else{
                            alert("密码不一致，请重新输入")
                        }
                    }else{
                        alert("再次输入的密码不能为空！")
                    }

                } else{
                    alert("密码不能为空！")
                }
            }else {
                alert("邮箱不能为空！")
            }
        }else{
            alert("用户名不能为空！")
        }

    }
</script>
</html>
