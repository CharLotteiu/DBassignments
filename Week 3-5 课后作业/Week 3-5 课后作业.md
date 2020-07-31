# Week 3-5 课后作业

### 题目一

考虑一个熟人表acquaintance (friend1, friend2, class)，表示friend1和friend2是朋友，class表示类别，比如“书友”，“球友”，“酒友”等等。

- 请写出该表的定义语句；

  ```mysql
  CREATE TABLE `acquaintance` (   
    `id` INT NOT NULL AUTO_INCREMENT,   
    `friend1` VARCHAR(225) NOT NULL,   
    `friend2` VARCHAR(225) NOT NULL,   
    `class` VARCHAR(225) NOT NULL,   
    PRIMARY KEY (`id`));
  ```

- 在MySQL数据库新建此表；

![](/Users/liulingling/Documents/Github/DBassignments/Week 3-5 课后作业/tableshoot.png)

- 用工具生成一些测试数据（测试数据生成工具推荐）

  暂时没有学会使用相关的测试数据生成工具，手动生成的数据