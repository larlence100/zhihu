<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionsRequest;
use App\Repositories\QuestionRepository;
use App\Topic;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{

    protected $question;

    public function __construct(QuestionRepository $question)
    {
        $this->middleware('auth')->except('index','show');
        $this->question = $question;
    }

    public function index()
    {
        $questions = $this->question->getQuestionsFeed();
        return view('questions.index',compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('questions.create');
    }

    /**
     * @param QuestionsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * author Fox
     */
    public function store(QuestionsRequest $request)
    {
        //topics create or delete
        $topics = $this->question->normalizeTopic($request->get('topics'));

        $data = array_merge($request->all(),['user_id'=>\Auth::id()]);

        //create question
        $question = $this->question->store($data);

        //create Topics
        $this->question->createTopics($question, $topics);

        return redirect()->route('questions.show',[$question->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = $this->question->ByIdWithTopcisAndAnswers($id);

        return view('questions.show',compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = $this->question->ByIdWithTopcisAndAnswers($id);


        if(\Auth::user()->owns($question)){
            return view('questions.edit',compact('question'));
        }

        return back();
    }

    /**
     * @param QuestionsRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * author Fox
     */
    public function update(QuestionsRequest $request, $id)
    {

        $question = $this->question->getById($id);
        $topics = $this->question->normalizeTopic($request->get('topics'));

        $question->update([
            'title' => $request->get('title'),
            'body' => $request->get('body'),
        ]);

        $question->topics()->sync($topics);

        return redirect()->route('questions.show',[$question->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = $this->question->getById($id);
        if(\Auth::user()->owns($question)){
            $this->question->destroy($id);
            return redirect()->route('questions.index');
        }

        return back();

    }


}
