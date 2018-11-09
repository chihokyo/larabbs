<?php

namespace App\Models;

class Reply extends Model
{
	// 只允许用户更改 content 字段
    protected $fillable = ['content'];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}