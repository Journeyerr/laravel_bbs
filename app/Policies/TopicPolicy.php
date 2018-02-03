<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topic;

class TopicPolicy extends Policy
{
    public function update(User $crrentUser, Topic $topic)
    {
        return $topic->user_id === $crrentUser->id;
    }

    public function destroy(User $crrentUser, Topic $topic)
    {
        return $topic->user_id === $crrentUser->id;
    }
}
