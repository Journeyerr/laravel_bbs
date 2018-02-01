<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

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
//        $this->authorize('edit', $user);
        return view('users.edit', compact('user'));
    }

    //执行更新资料
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->all());
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功');
    }

}
