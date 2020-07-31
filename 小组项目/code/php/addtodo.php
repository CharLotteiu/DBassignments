<?php session_start();
//create by崔冰
?>


<html>
    <head>

	<!-- Layui -->
	<link rel="stylesheet" href="../layui/css/layui.css"  media="all">
    <script src="../layui/layui.js" charset="utf-8"></script>
    </head>
    <body>

		<!-- NEW TODO Create by 崔冰-->
		<div class="panel" id="newtodo"> <!-- id="newtodo"  Edited by 苏珊-->
			<div class="panel-heading">
				<h3 class="panel-title">新增 TO-DO</h3>
			</div>
			<div class="panel-body">
				<!-- method="POST" onsubmit="return false" action="##" id="editform"  Edited by 苏珊-->
				<form method="POST" onsubmit="return false" action="##" id="editform">
					<div class="form-group">
						<label for="content">内容</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="lnr lnr-pencil"></i></span>
							<input id="content" name="content" type="text" class="form-control" required>
						</div>
					</div>
					<div class="form-group">
						<label style="display:block" for="importance">重要性</label>
						<div id="importance"></div>
						<input type="hidden" id="imporate" name="imporate" required>
					</div>
					<div class="form-group">
						<label for="calendar">截止日期</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="lnr lnr-calendar-full"></i></span>
							<input name="enddate" id="calendar" type="text" class="form-control" required>
						</div>
					</div>
					<div class="form-group">
						<label for="list">清单分类</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="lnr lnr-tag"></i></span>
							<input name="list" id="list" type="text" class="form-control">
							
							<datalist id="listname">
								<?php
									include ('conn.php');
									$sql = 'select * from list where uid = "'.$_SESSION['userid'].'"';									
									$result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
									
									while ($query = mysqli_fetch_array($result,MYSQLI_ASSOC)){										
										echo '<option value="'.$query['list_name'].'"></option>';
										
									}	
								?>
							</datalist>
						</div>
					</div>
				
					<input type="hidden" id="userid" name="userid" value="<?php echo $_SESSION['userid']?>">
					<div class="form-group">
						<button style="display:block;margin:0 auto" type="submit" class="btn btn-info" onclick='submitnew();'>保存</button> 
						<!-- onclick='submitfilter();' Edited by 苏珊 -->
					</div>
				</form>
			</div>
		</div>
		<!-- END NEW TODO -->
    </body>
</html>