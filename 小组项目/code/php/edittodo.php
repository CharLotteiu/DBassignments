<?php session_start();?>
<?php
//Created by 刘玲玲
include ('conn.php');

$tid = $_POST['id'];

$todo_sql = 'SELECT todo.content, todo.ddl, todo.importance, todo.status, list.list_name FROM todo LEFT JOIN list ON todo.lid=list.lid WHERE tid='.$tid;
$todo_result = mysqli_query($conn,$todo_sql);
$todo_query = mysqli_fetch_array($todo_result,MYSQLI_ASSOC);

?>

<html>
    <head>

	<!-- Layui -->
	<link rel="stylesheet" href="../layui/css/layui.css"  media="all">
    <script src="../layui/layui.js" charset="utf-8"></script>
    </head>
    <body>
        <!-- EDIT TODO -->
        <div class="panel" id="edittodo">
            <div class="panel-heading">
                <h3 class="panel-title">修改 Todo</h3>
            </div>
            <div class="panel-body">
                <form method="POST" onsubmit="return false" action="##" id="editform">
                    <div class="form-group">
                        <label for="content">内容</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="lnr lnr-pencil"></i></span>
                            <input name="content" id="content" name="content" type="text" class="form-control" value="<?php echo $todo_query['content']?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label style="display:block" for="importance">重要性</label>
                        <div id="importance"></div>
                        <input type="hidden" id="imporate" name="imporate" value="<?php echo $todo_query['importance'];?>">
                    </div>
                    <div class="form-group">
                        <label for="calendar">截止日期</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="lnr lnr-calendar-full"></i></span>
                            <input name="enddate" id="calendar" type="text" class="form-control" value="<?php echo $todo_query['ddl']?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="list">清单分类</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="lnr lnr-tag"></i></span>
                            <input name="list" id="list" type="text" class="form-control" value="<?php echo $todo_query['list_name']?>" list="listname" >
                            <datalist id="listname">
                                <?php
                                    foreach($list_names as $list_name){
                                            echo '<option value="'.$list_name['list_name'].'">'.$list_name['list_name'].'</option>';
                                    }
                                ?>
                            </datalist>
                        </div>
                    </div>
                    <div class="form-group">
                        <label style="display:block" for="status">状态</label>
                        <?php
                            if($todo_query['status']==0){
                                echo "<span id='status' class='label label-warning'>进行中</span>";
                            }
                            else if($todo_query['status']==1){
                                echo "<span id='status' class='label label-success'>已完成</span>";
                            }
                            else{
                                echo "<span id='status' class='label label-danger'>已逾期</span>";
                            }
                        ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" id="todoid" name="todoid" value="<?php echo $tid?>">
                        <input type="hidden" id="userid" name="userid" value="<?php echo $_SESSION['userid']?>">
                    </div>
                    <div class="form-group">
                        <button style="display:block;margin:0 auto" type="submit" class="btn btn-info" onclick='submit();'>保存</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END EDIT TODO -->
    </body>
</html>