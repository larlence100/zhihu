@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">控制台</div>
                @include('flash::message')
                <div class="panel-body">
                    登录成功啦！
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
