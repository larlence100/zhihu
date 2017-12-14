<?php
namespace App\Repositories;
use App\Question;
use App\Topic;

/**
 * User: liujianjiang
 */
class QuestionFollowRepository
{
    use BaseRepository;

    protected $model;


    public function __construct(Question $question)
    {
        $this->model = $question;
    }



    
}