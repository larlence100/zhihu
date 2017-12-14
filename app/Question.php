<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['title', 'body', 'user_id'];

    public function topics()
    {
        return $this->belongsToMany(Topic::Class)->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::Class);
    }


    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function scopePublished($query)
    {
        return $query->where('is_hidden','F');
    }
}
