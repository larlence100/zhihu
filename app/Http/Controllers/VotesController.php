<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Repositories\AnswerRepository;
use App\User;
use Illuminate\Http\Request;

class VotesController extends Controller
{
    protected $answer;

    public function __construct(AnswerRepository $answer)
    {
        $this->answer = $answer;
    }

    public function users($id)
    {
        if(user('api')->hasVoteFor($id)){
            return response()->json(['voted' => true]);
        }
        return response()->json(['voted' => false]);
    }

    public function vote(){


        $answer = $this->answer->getById(request('answer'));

        $voted = user('api')->voteFor(request('answer'));

        if (count($voted['attached']) > 0) {
            $answer->increment('votes_count');

            return response()->json(['voted' => true]);
        }
        $answer->decrement('votes_count');

        return response()->json(['voted' => false]);

    }
}
