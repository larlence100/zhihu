<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Comment;
use App\Question;
use App\Repositories\AnswerRepository;
use App\Repositories\CommentRepository;
use App\Repositories\QuestionRepository;


class CommentsController extends Controller
{
    protected $answer;
    protected $question;
    protected $comment;

    public function __construct(AnswerRepository $answer, QuestionRepository $question, CommentRepository $comment)
    {
        $this->answer = $answer;
        $this->question = $question;
        $this->comment = $comment;
    }

    public function answer($id)
    {
        $answers = $this->answer->getAnswerCommentsById($id);
        return $answers->comments;
    }

    public function question($id)
    {
        $questions = $this->question->getQuestionCommentsById($id);
        return $questions->comments;
    }

    public function store()
    {
        $model = $this->getModelNameFromType(request('type'));
        $comment = $this->comment->store([
            'commentable_id'   => request('model'),
            'commentable_type' => $model,
            'user_id'          => user('api')->id,
            'body'             => request('body')
        ]);
        return $comment;
    }

    private function getModelNameFromType($type)
    {
        return $type === 'question' ? 'App\Question' : 'App\Answer';
    }
}
