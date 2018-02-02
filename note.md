
laravel代码生成器
     安装：composer require 'summerblue/generator:~0.5' --dev

     使用：php artisan make:scaffold Projects --schema="name:string:index,description:text:nullable,subscriber_count:integer:unsigned:default(0)"

            备注：   unsigned() —— 设置不需要标识符（unsigned）
                    default() —— 为字段添加默认值。
                    nullable() —— 可为空

    * 作用：完成注册路由、新建模型、新建表单验证类、新建资源控制器以及所需视图文件等任务

