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
 

#####导航的 Active 状态

* composer require "hieu-le/active:~3.5"

>用法： 如果传参满足指定条件 ($condition) ，此函数将返回 $activeClass，否则返回 $inactiveClass。

    class = " {{ active_class((if_route('categories.show') && if_route_param('category', 1))) }}" 
    
|   

        if_route() - 判断当前对应的路由是否是指定的路由；
        if_route_param() - 判断当前的 url 有无指定的路由参数。
        if_query() - 判断指定的 GET 变量是否符合设置的值；
        if_uri() - 判断当前的 url 是否满足指定的 url；
        if_route_pattern() - 判断当前的路由是否包含指定的字符；
        if_uri_pattern() - 判断当前的 url 是否含有指定的字符；>


#####Guzzle 库是一套强大的 PHP HTTP 请求套件

* 安装：composer require "guzzlehttp/guzzle:~6.3"

* 使用：https://github.com/guzzle/guzzle


##### PinYin 基于 CC-CEDICT 词典的中文转拼音工具

* 安装：  composer require "overtrue/pinyin:~3.0"

* 使用：   https://github.com/overtrue/pinyin


    
##### 一个模块开发流程

* 控制器，模型，视图，Request <br><br>
    [数据生成：database/factories/XXXXFactory.php]   <br><br>
    [数据填充逻辑:database/seeds/XXXXTableSeeder.php]
    
    >模型:
    
    * 一个 [ 话题 ] 模型里面： " 获取该话题所有 回复 ->hasMany(‘回复模型’)"
            
             return $this->hasMany(Reply::class);

    * 一个 [ 话题 ] 模型里面：" 获取该话题所属 用户 ->belongsTo(‘用户模型’)  "
            
            return $this->belongsTo(User::class);
            
    > Request  App\Http\Requests\UserRequest.php:
    
            //自定义字段规则
            public function rules()
                {
                    return [
                        'name' => 'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users,name,' . Auth::id()
                    ];
                }
                
             //自定义不满足时提示的信息    
            public function messages()
                {
                    return [
                        'name.unique' => '用户名已被占用，请重新填写',
                        'name.regex' => '用户名只支持中英文、数字、横杆和下划线。',
                    ];
                }
            
    > App\Http\Controllers\UserController.php
    
             //执行更新资料
             public function update(UserRequest $request)
             {
                $data = $request->all();   //  自动注入 Request\UserRequest 里面定义规则
             }
         
    > 验证不通过，在视图可以通过 $errors 变量获得错误信息，可以通过 count($errors) 判断是否产生错误
    
            @if (count($errors) > 0)
                    <h4>有错误发生：</h4>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
            @endif
            
    
##### Laravel权限管理系统

*   Laravel-permission : https://github.com/spatie/laravel-permission

    >数据表各自的作用：
    
        * roles —— 角色的模型表；
        * permissions —— 权限的模型表；
        * model_has_roles —— 模型与角色的关联表，用户拥有什么角色在此表中定义，一个用户能拥有多个角色；
        * role_has_permissions —— 角色拥有的权限关联表，如管理员拥有查看后台的权限都是在此表定义，一个角色能拥有多个权限；
        * model_has_permissions —— 模型与权限关联表，一个模型能拥有多个权限。