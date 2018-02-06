<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'introduction', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //获取 用户 所有话题
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    // 获取  用户  所有的回复
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    //将消息通知清零
    public function notifications()
    {
        $this->notification_count  = 0;
        $this->save();
    }
}
