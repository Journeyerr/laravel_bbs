<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedRolesAndPermissionsData extends Migration
{
    /**
     * 利用创建表的方法，填充权限角色表
     *
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 清除缓存
        app()['cache']->forget('spatie.permission.cache');

        // 先创建权限
        \Spatie\Permission\Models\Permission::create(['name' => 'manage_contents']);
        \Spatie\Permission\Models\Permission::create(['name' => 'manage_user']);
        \Spatie\Permission\Models\Permission::create(['name' => 'manage_settings']);

        // 创建站长角色，并赋予权限
        $founder = \Spatie\Permission\Models\Role::create(['name' =>'Founder']);
        $founder->givePermissionTo('manage_contents');
        $founder->givePermissionTo('manage_user');
        $founder->givePermissionTo('manage_settings');

        // 创建管理员角色，并赋予权限
        $maintainer = \Spatie\Permission\Models\Role::create(['name' => 'Maintainer']);
        $maintainer->givePermissionTo('manage_contents');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 清除缓存
        app()['cache']->forget('spatie.permission.cache');

        // 清空所有数据表数据
        $tableNames = config('permission.table_names');

        Model::unguard();
        DB::table($tableNames['role_has_permissions'])->delete();
        DB::table($tableNames['model_has_roles'])->delete();
        DB::table($tableNames['model_has_permissions'])->delete();
        DB::table($tableNames['roles'])->delete();
        DB::table($tableNames['permissions'])->delete();
        Model::reguard();
    }
}
