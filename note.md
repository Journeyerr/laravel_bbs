#####laravel代码生成器：

* 安装：composer require 'summerblue/generator:~0.5' --dev

* 使用：php artisan make:scaffold Projects --schema="name:string:index,description:text:nullable,subscriber_count:integer:unsigned:default(0)"

 * 作用：完成注册路由、新建模型、新建表单验证类、新建资源控制器以及所需视图文件等任务
  
* 备注：  
 
        unsigned() —— 设置不需要标识符（unsigned）
        default() —— 为字段添加默认值。
        nullable() —— 可为空
   

#####laravel数据填充：（生成用户）

*   UserFactory  …… 按规则生成一个数据用户并返回
*   UsersTableSeeder …… 接收生成的用户，并按需求插入数据库 
    
        // 获取 Faker 实例
               $faker = app(Faker\Generator::class);
               
        // 生成数据集合 times(10) 表示生成10条
               $users = factory(User::class)->times(10)->make()
               
*    php artisan db:seed --class=UsersTableSeeder  ……生成数据


