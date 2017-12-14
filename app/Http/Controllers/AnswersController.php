<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\AnswersRequest;
use App\Repositories\AnswerRepository;


class AnswersController extends Controller
{
    protected $answer;

    public function __construct(AnswerRepository $answer)
    {
        $this->answer = $answer;
    }

    public function store(AnswersRequest $request, $question)
    {
        $data = array_merge($request->all(),[
            'user_id' => \Auth::id(),
            'question_id' => $question,
        ]);

        $answer = $this->answer->store($data);

        $answer->question()->increment('answers_count');

        return back();
    }
}
