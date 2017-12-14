<?php
namespace App\Repositories;
use App\Answer;


/**
 * User: liujianjiang
 */
class AnswerRepository
{
    use BaseRepository;

    protected $model;

    public function __construct(Answer $answer)
    {
        $this->model = $answer;
    }

    public function getAnswerCommentsById($id)
    {

        return $this->model->with('comments', 'comments.user')->where('id',$id)->first();
    }


    
}