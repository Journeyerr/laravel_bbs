<?php

namespace App\Observers;

use App\Handlers\SlugTranslate;
use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function saving(Topic $topic)
    {

        // 使用 HTMLPurifier 过滤 xss 攻击， 在 config/purifier.php 下配置
        $topic->body = clean($topic->body, 'user_topic_body');

        // 使用 bootstrap/helpers.php 在创建话题时自动生成话题摘要
        $topic->excerpt = make_excerpt($topic->body);

        //使用 App\Handlers\SlugTranslate.php 对字段slug 进行翻译
        
        if( ! $topic->slug ){
            $topic->slug = app(SlugTranslate::class)->translate($topic->title);
        }
    }
}