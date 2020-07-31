# Week 10 课后作业

### 题目一

- 完成数据库设计案例分析一中其他概念设计

- 完成数据库设计案例分析一中其他逻辑设计与物理实施

  - 用户信息实体集

    <img src="/Users/liulingling/Documents/Github/DBassignments/Week 10 课后作业/用户实体集.jpg"  />

  - 管理员实体集

    ![](/Users/liulingling/Documents/Github/DBassignments/Week 10 课后作业/管理员.jpg)

  - 图书信息实体集

    ![](/Users/liulingling/Documents/Github/DBassignments/Week 10 课后作业/图书信息实体集.jpg)

  - 图书评论实体集

    ![](/Users/liulingling/Documents/Github/DBassignments/Week 10 课后作业/图书评论.jpg)

  - 订单实体集

    ![](/Users/liulingling/Documents/Github/DBassignments/Week 10 课后作业/订单.jpg)

  - 图书分类实体

    ![](/Users/liulingling/Documents/Github/DBassignments/Week 10 课后作业/图书分类.jpg)

  - 图书订购者详情实体集

    ![](/Users/liulingling/Documents/Github/DBassignments/Week 10 课后作业/图书订购者.jpg)

  ### 题目二

对于设计案例分析一中的系统，完善其功能，考虑增加如下功能：

- 添加图书条码扫描与小票打印功能
- 添加图书退换货
- 添加图书促销与兑换赠品
  对上述功能，进行需求分析，进行数据库概念设计、逻辑设计和物理设计。

1. 图书条码扫描和小票打印

   在图书信息表里增添一栏ISBN编码，前端接入图书条码扫描的API，扫描后依据ISBN编码在图书信息表中查询

2. 图书退换货

   新增加“订单-图书关系表”，用来记录每个订单都包含哪些图书，有多少本，买家是否选择退换等

   ![](/Users/liulingling/Documents/Github/DBassignments/Week 10 课后作业/订单-图书关系.jpg)

   是否退换一栏，退为“0”，换为“1”，没有选择退换为空值。

   退货后仓库需要直接入库，换货后除了仓库入库还需要为换的书开一个新的订单用来记录并进行出库操作。

3. 图书促销与兑换赠品

   在图书信息表里增添一栏“促销状态”，在订单表中增添一栏“赠品编码”