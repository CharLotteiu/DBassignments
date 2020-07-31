<?php
//header('Content-Type: application/json; charset=utf-8');
include ('conn.php');
    
    $uid = $_POST['userid'];
    $tid = $_POST['todoid'];
    $content = $_POST['content'];
    $enddate = $_POST['enddate'];
    $list = $_POST['list'];
    $importance = $_POST['imporate'];

    //判断list是否是新增的
    if($list==''){
        $lid='NULL';
        $update_sql = "UPDATE todo
                    SET ddl='{$enddate}',content='{$content}',lid=NULL,importance='{$importance}'
                    WHERE tid=".$tid;
    }
    else{
        $list_sql = "SELECT lid FROM list WHERE `uid`='{$uid}' AND `list_name`='{$list}'";
        $list_result = mysqli_query($conn,$list_sql);
        $list_query = mysqli_fetch_array($list_result,MYSQLI_ASSOC);
        if(!$list_query){//list是新增的
            $insert_sql = "INSERT INTO `list` (`lid`, `uid`, `list_name`) VALUES (NULL,'{$uid}','{$list}')";
            $insert_result = mysqli_query($conn,$insert_sql) or die(mysqli_error($conn));
            $lid_sql = "SELECT lid FROM list WHERE `uid`='{$uid}' AND `list_name`='{$list}'";
            $lid_result = mysqli_query($conn,$lid_sql) or die(mysqli_error($conn));
            $lid_query =  mysqli_fetch_array($lid_result,MYSQLI_ASSOC);
            $lid=$lid_query['lid'];
        }
        else{//list不是新增的
            $lid=$list_query['lid'];
        }
        $update_sql = "UPDATE todo
                    SET ddl='{$enddate}',content='{$content}',lid='{$lid}',importance='{$importance}'
                    WHERE tid=".$tid;
    }
    
    if(mysqli_query($conn,$update_sql)){
        $result['status']='succeeded';
    }
    else{
        $result['status']=mysqli_error($conn);
    }

    echo json_encode($result);

    mysqli_close($conn);

?>