@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-1">
                <div class="panel panel-default">
                    @include('flash::message')
                    <div class="panel panel-heading">
                       {{ $question->title }}
                        @foreach($question->topics as $topic)
                            <span class="label label-success">{{$topic->name}}</span>
                        @endforeach
                    </div>
                    <div class="panel-body">
                        {!! $question->body !!}
                    </div>
                    <div class="action">
                        @if(Auth::check() && Auth::user()->owns($question))
                              <!--<span class="delete-button"><a  href="/questions/{{$question->id}}/edit">编辑</a> </span>-->
                                  <button class="delete-button" onclick="window.location.href='/questions/{{$question->id}}/edit'">编辑</button>
                            <form class="form-group" action="/questions/{{ $question->id }}" method="post">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}


                                <button class="delete-button" type="submit">刪除 </button>
                            </form>
                        @endif
                        <comments type="question" model="{{$question->id}}" count="{{$question->comments()->count()}}"></comments>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                   <question-follow question="{{$question->id}}" name="{{$question->user->name}}"></question-follow>


            </div>
            <div class="col-md-8 col-md-offset-1">
                <div class="panel panel-default">
                    @include('flash::message')
                    <div class="panel panel-heading">
                        {{$question->answers_count}} 条答案
                    </div>
                    <div class="panel-body">
                        @foreach($question->answers as $answer)
                            <div class="media">
                                <div class="media-left">
                                    <user-vote answer="{{$answer->id}}" count="{{$answer->votes_count}}"></user-vote>
                                    <!--<a href="">
                                        <img width="48" src="{{ $answer->user->avatar }}">
                                    </a>-->
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="/user/{{ $answer->user->name }}">
                                            {{ $answer->user->name }}
                                        </a>
                                    </h4>
                                    {!! $answer->body !!}
                                </div>
                                <comments type="answer" model="{{$answer->id}}" count="{{$answer->comments()->count()}}"></comments>
                            </div>
                        @endforeach
                        @if(Auth::check())
                        <form action="/questions/{{$question->id}}/answer" method="post">
                            {{ csrf_field() }}
                            <textarea class="form-control " name="body"></textarea>
                            @if ($errors->has('body'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                            @endif
                            <button class="btn btn-success pull-right" type="submit">提交问题</button>
                        </form>
                            @else
                                <a href="/login" class="btn btn-success btn-block">登陸后體檢答案</a>
                            @endif

                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <user-follow user="{{$question->user_id}}" username="{{$question->user->name}}"></user-follow>

            </div>
        </div>
    </div>

@endsection
