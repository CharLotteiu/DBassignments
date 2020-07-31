<?php
//create by崔冰  新增清单js显示form内容
include('php/conn.php');
$list_sql = "select lid, list_name from list where uid=".$_SESSION['userid'];
$list_result = mysqli_query($conn,$list_sql);
$list_name=[];
echo '<div class="layui-row" id="test" style="display: none;">
            <div class="layui-col-md10">
                <form class="layui-form" action="php/add_list.php" method="post" id="addEmployeeForm" >
                    <div class="layui-form-item">
                        <label class="layui-form-label" style="padding-left:-50px;">名称:</label>
                        <div>
                            <input type="text" placeholder="请输入清单名称……" lay-verify="questionnaireName" name="addl" id="questionnaireName" class="layui-input" style=" margin-left: 30px">
                        </div>
                    </div>
                  
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button type="submit" lay-submit="" lay-filter="suu" name ="addlist" class="layui-btn layui-btn-normal tijiao" >提交</button>
                        </div>
                    </div> 
                </form>
            </div>
        </div>';

while($list_query = mysqli_fetch_array($list_result,MYSQLI_ASSOC)){
    echo '<li style="margin-top:20px; margin-bottom:20px">
	<a style="display:inline; margin-top:10px; margin-bottom:10px; padding-left:60px" href="listdetail.php?lid='.$list_query['lid'].'&name='.$list_query['list_name'].'">'.$list_query['list_name'].'</a>
    <i style="margin-right:40px; float:right" class="fa fa-trash-o" onclick="DelList('.$list_query['lid'].')"></i>
    </li>';
    array_push($list_name,$list_query['list_name']);

}

?>
<li><button style="margin-left: 60px;margin-top: 10px;margin-bottom: 10px;"title="新增清单" type="button" class="btn btn-primary btn-xs" id="add" >新增清单</button></li>