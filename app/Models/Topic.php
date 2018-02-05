<?php

namespace App\Models;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'category_id', 'excerpt', 'slug'];

    // 获取当前帖子所属的分类
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    //获取当前帖子所属的作者
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeWithOrder($query, $order)
    {
        // 不同的排序，使用不同的数据读取逻辑
        switch ($order) {
            case 'recent':
                $query = $query->orderBy('updated_at', 'desc');
                break;

            default:
                $query = $query->orderBy('created_at', 'desc');
                break;
        }
        // 预加载防止 N+1 问题
        return $query->with('user', 'category');
    }

    //允许附加 URL 参数的设定 把需要的参数都接到url上
    public function link($params = [])
    {
        //array_merge() 函数把一个或多个数组合并为一个数组
        return route('topics.show', array_merge([$this->id, $this->slug], $params));
    }

    // 获取 该帖子 所有的回复
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }


}
