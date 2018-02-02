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


#####laravel预加载

* 获取所有书籍及其作者的数据


    $books = App\Book::all();
    
    foreach ($books as $book) {
        echo $book->author->name;
    }
    
> 上方的循环会运行一次查找并取回所有数据表上的书籍，接着每本书会运行一次查找作者的操作。

> 因此，若存在着 25 本书，则循环就会执行 26 次查找：1 次是查找所有书籍，其它 25 次则是在查找每本书的作者。

* 查找时使用 with 方法来指定想要预加载的关联数据


    $books = App\Book::with('author')->get();
    
    foreach ($books as $book) {
        echo $book->author->name;
    }
    
>对于该操作则只会执行两条 SQL 语句：

    select * from books
    
    select * from authors where id in (1, 2, 3, 4, 5, ...)
    
* 有时你可能想要在单次操作中预加载多种不同的关联。要这么做，只需传递额外的参数至 with 方法即可：
   
    $books = App\Book::with('author', 'publisher')->get();



#####安装 Debugba

* 安装：

         composer require "barryvdh/laravel-debugbar:~3.1" --dev
         
* 开启：

        php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"
        
        config/debugbar.php：    'enabled' => env('APP_DEBUG', false),
 




