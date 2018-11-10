<?php

namespace App\Observers;
use App\Notifications\TopicReplied;

use App\Models\Reply;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{

    public function created(Reply $reply)
    {
    	$topic = $reply->topic;
        $reply->topic->increment('reply_count', 1);

        // 通知作者话题被回复了
        $topic->user->notify(new TopicReplied($reply));
    }
    
    public function creating(Reply $reply)
    {
        $reply->content = clean($reply->content, 'user_topic_body');
    }
    public function deleted(Reply $reply)
    {
        $reply->topic->decrement('reply_count', 1);
    }
}