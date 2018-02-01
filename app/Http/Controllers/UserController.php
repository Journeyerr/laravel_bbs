<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;

class UserController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth', [
//            'edit',
//            'update'
//        ]);
    }

    //用户个人中心
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    //显示更新资料界面
    public function edit(User $user)
    {
//
        return view('users.edit', compact('user'));
    }

    //执行更新资料
    public function update(UserRequest $request, User $user)
    {
        $uploader = new ImageUploadHandler;

        $this->authorize('edit', $user);        //  App\Policies\UserPolicy 是否为当前登录用户
        $data = $request->all();         //  自动注入 Request\UserRequest 里面定义规则

        if($request->avatar) {
            $res = $uploader->save($request->avatar, 'avatar', $user->id);
            if($res){
                $data['avatar'] = $res['path'];
            }
        }
        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功');
    }



}
