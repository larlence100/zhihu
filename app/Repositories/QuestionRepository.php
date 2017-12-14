<?php
namespace App\Repositories;
use App\Question;
use App\Topic;

/**
 * User: liujianjiang
 */
class QuestionRepository
{
    use BaseRepository;

    protected $model;

    public function __construct(Question $question)
    {
        $this->model = $question;
    }

    public function getQuestionsFeed()
    {

        return $this->model->published()->latest('updated_at')->with('user')->get();
    }

    public function ByIdWithTopcisAndAnswers($id)
    {
        return $this->model->where('id',$id)->with(['topics', 'answers', 'user'])->first();
    }

    public function getQuestionCommentsById($id)
    {
        return $this->model->with('comments', 'comments.user')->where('id',$id)->first();
    }

    /**
     * @param $question
     * @param $topics
     * author Fox
     */
    public function createTopics($question, $topics)
    {
        $question->topics()->attach($topics);
    }

    /**
     * @param array $topics
     * @return array
     * author Fox
     */
    public function normalizeTopic(array $topics){
        return collect($topics)->map(function($topic){

            //判断是增的Topic 还是已经有的topic
            if(is_numeric($topic)){
                //话题关联数量增加
                Topic::find($topic)->increment('questions_count');

                return (int) $topic;
            }

            //当topic没有的时候新增
            $newTopic = Topic::create(['name' => $topic,'questions_count' => 1]);
            return $newTopic->id;
        })->toArray();
    }

    
}