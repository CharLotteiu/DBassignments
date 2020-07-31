# Week 6 课后作业

### 题目〇

- 测试使用python或php连接两种以上数据库服务端，并执行简单查询并打印返回结果

1. 连接SQLite

   ```php
   <?php
      class SQLiteDB extends SQLite3
      {
         function __construct()
         {
            $this->open('/Users/liulingling/test.db');
         }
      }
      $db = new SQLiteDB();
      if(!$db){
         echo $db->lastErrorMsg();
      } else {
         echo "Yes, Opened database successfully\n";
      }
   
   $sql = "select * from company";
   
   $ret = $db->query($sql);
   
   while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
       var_dump($row);
   }
   ?>
   ```

   打印结果

   <img src="/Users/liulingling/Documents/Github/DBassignments/Week 6 课后作业/连接sqlite.jpg" style="zoom:50%;" />

2. 连接MySQL

   见下文

- 测试python或php使用两种以上不同方法连接同一数据库服务端，并执行简单查询并打印返回结果

1. Mysqli面向过程方式

   ```php
   <?php
   
   $conn = mysqli_connect("localhost", "root", "") or die("连接数据库失败" . mysqli_error($conn));
   mysqli_select_db($conn, "blcu") or die("选择数据库失败" . mysqli_error($conn));
   mysqli_query($conn, "set names utf8");
   
   $sql = "SELECT * from customers";
   $search_result = mysqli_query($conn,$sql)or die(mysqli_error($conn));
   while($search_query = mysqli_fetch_array($search_result,MYSQLI_ASSOC)){
       var_dump($search_query);
   }
   
   ?>
   ```

   打印结果

   <img src="/Users/liulingling/Documents/Github/DBassignments/Week 6 课后作业/面向过程方式截图.jpg" style="zoom:50%;" />

2. PDO方式

   ```php
   <?php
   
   $dsn = 'mysql:dbname=blcu;localhost';
   $user = 'root';
   $password = '';
   $dbh = new PDO($dsn, $user, $password);
   $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $r = $dbh->query('SELECT * FROM products');
   var_dump($r);
   foreach($r as $v) {
       var_dump($v);
   }
   
   ?>
   ```

   打印结果

   <img src="/Users/liulingling/Documents/Github/DBassignments/Week 6 课后作业/pdo方式截图.jpg" style="zoom:50%;" />