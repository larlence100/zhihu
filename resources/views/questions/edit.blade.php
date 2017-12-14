@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">发布问题</div>
                    @include('flash::message')
                    <div class="panel-body">
                        <form action="/questions/{{$question->id}}" method="post">
                           {{ method_field('PATCH') }}
                            {!! csrf_field() !!}
                            <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="title">标题</label>
                                <input type="text" value="{{ $question->title }}" name="title" class="form-control" placeholder="标题" id="title">
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group {{ $errors->has('body') ? ' has-error' : '' }}">
                                <label for="body">描述</label>
                                <textarea name="body" class="form-control " placeholder="描述" id="body"> {!! $question->body  !!}</textarea>
                                @if ($errors->has('body'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <select name="topics[]" class="js-example-basic-multiple form-control js-data-example-ajax" multiple="multiple">
                                    @foreach($question->topics as $topic)
                                        <option value="{{ $topic->id }}" selected="selected">{{ $topic->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success pull-right" type="submit">提交问题</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('js')
    <script>
        $(document).ready(function() {
            function formatTopic (topic) {
                return "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'>" +
                topic.name ? topic.name : "Laravel"   +
                    "</div></div></div>";
            }

            function formatTopicSelection (topic) {
                return topic.name || topic.text;
            }

            $(".js-example-basic-multiple").select2({
                tags: true,
                placeholder: '选择相关话题',
                minimumInputLength: 2,
                ajax: {
                    url: '/api/topics',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function (data, params) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                templateResult: formatTopic,
                templateSelection: formatTopicSelection,
                escapeMarkup: function (markup) { return markup; }
            });
        });

    </script>
    @endsection
@endsection
