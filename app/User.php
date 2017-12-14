<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Mail;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'confirmation_token', 'api_token', 'settings'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'settings' => 'array'
    ];

    /**
     * @return Setting
     */
    public function settings()
    {
        return new Setting($this);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function owns(Model $model)
    {
        return $this->id == $model->user_id;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function follows()
    {
        return $this->belongsToMany(Question::class, 'user_question')->withTimestamps();
    }

    /**
     * @param $question
     * @return array
     */
    public function followThis($question)
    {
        return $this->follows()->toggle($question);
    }

    /**
     * @param $question
     * @return bool
     */
    public function followed($question)
    {
        return !!$this->follows()->where('question_id', $question)->count();
    }

    public function followers()
    {
        return $this->belongsToMany(self::class, 'followers', 'follower_id', 'followed_id')->withTimestamps();
    }

    public function followersUser()
    {
        return $this->belongsToMany(self::class, 'followers', 'followed_id', 'follower_id')->withTimestamps();
    }

    public function followThisUser($user)
    {
        return $this->followers()->toggle($user);
    }

    public function votes()
    {
        return $this->belongsToMany(Answer::class, 'votes')->withTimestamps();
    }

    public function voteFor($answer)
    {
        return $this->votes()->toggle($answer);
    }

    public function hasVoteFor($answer){
        return $this->votes()->where('answer_id', $answer)->count();
    }

    /*public function message()
    {
        $this->hasMany(Message::class,'to_user_id');
    }*/

    public function messages()
    {
        return $this->hasMany(Message::class, 'to_user_id');
    }

    /**
     * @param string $token
     * author Fox
     */
    public function sendPasswordResetNotification($token)
    {
        $content = url(config('app.url').route('password.reset', $token));
        Mail::raw($content, function ($m) {
            $m->from('yang.liu@cbec365.com', 'larlence');
            $m->to($this->email)-> subject('激活账户邮件');
        });
    }

}
