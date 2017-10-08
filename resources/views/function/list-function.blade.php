@extends('home-user.index')
@section('title')
    {{'Quản lý chức năng'}}
@endsection
@section('user-content')
    @if(session()->has('addAcademy'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('addAcademy')}}</div>
    @endif
    @if(session()->has('addLearningPrograming'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('addLearningPrograming')}}</div>
    @endif
    @if(session()->has('updateLearn'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('updateLearn')}}</div>
    @endif
    @if(session()->has('updateAcademy'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('updateAcademy')}}</div>
    @endif
    @if(session()->has('deleteLearn'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('deleteLearn')}}</div>
    @endif
    @if(session()->has('deleteAcademy'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('deleteAcademy')}}</div>
    @endif
    @if(session()->has('deleteManyAcademy'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('deleteManyAcademy')}}</div>
    @endif
    @if(session()->has('deleteManyLearn'))
        <div class="alert alert-success myLabel" role="alert">{{session()->get('deleteManyLearn')}}</div>
    @endif
    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="name-page-profile">Quản lý chung</span>
            <span class="glyphicon glyphicon-menu-right small"></span>
            <a href="manage-function" style="color: #333">
                <span class="company-register name-page-profile">Quản lý chức năng</span>
            </a>
        </div>
        <div class="panel-body">
            @include('function.learning-programing')
            @include('function.academy')
        </div>
    </div>
    <script>
        $('#manage-function').addClass('menu-menu');
        $('a#manage-function').css('color', '#000000');
    </script>
@endsection