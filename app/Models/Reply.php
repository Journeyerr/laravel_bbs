<?php

namespace App\Models;

class Reply extends Model
{
    protected $fillable = ['content'];

    //获取所属的话题
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    //获取回复所属的用户
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
