<?php

namespace App\Observers;

use App\Models\Reply;
use App\Models\User;
use App\Notifications\TopicReplied;
use Illuminate\Support\Facades\Auth;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function creating(Reply $reply)
    {
        //利用扩展包过滤xss攻击
        $reply->content = clean($reply->content, 'user_topic_body');
    }

    public function created(Reply $reply)
    {
        //发表的时候，监听加一
        $reply->topic->increment('reply_count', 1);

        //获取该回复对应的话题
        $topic = $reply->topic;

        // 如果评论的作者不是话题的作者，才需要通知
        if( $reply->user_id != $topic->user_id ){

            $user = User::find( $topic->user_id );
            $user->increment('notification_count');

            $topic->user->notify(new TopicReplied($reply));
        }
    }
}