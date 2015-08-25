@extends('layouts.main')

@section('head')
    Edit Skill Information
@stop

@section('head-contents')
    {{ HTML::script('js/jquery-1.11.0.min.js') }}
    {{ HTML::script('js/taskminator.js') }}
    <script>
        $(document).ready(function(){
            $('#taskcategory').change(function(){
                $('#taskitems').empty();
                $.ajax({
                    type    :   'POST',
                    url     :   '/chainCategoryItems',
                    data    :   $('#doEditSkillInfo').serialize(),
                    success :   function(data){
                        $.each(data, function(key, value){
                            $('#taskitems').append('<option value="'+ value['itemcode'] +'">'+value['itemname']+'</option>');
                        });
                    },error :   function(){
                        alert('ERR500 : Please check network connectivity');
                    }
                })
            });

            $('.remove-skill').click(function(){
                if(confirm('Do you really want to remove this skill?')){
                    location.href = $(this).attr('data-href');
                }
            });
        });
    </script>
@stop

@section('user-name')
    {{ Auth::user()->firstName }} {{ Auth::user()->lastName }}
@stop

@section('contents')
    <div class="page-title">
        <h1>
            Edit Personal Information
        </h1>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <ul class="breadcrumb">
                <li>
                    <a href="/"><i class="icon-home"></i></a>
                </li>
                <li>
                    <a href="/editProfile">Edit Profile</a>
                </li>
                <li class="active">
                    Edit Personal Information
                </li>
            </ul>
        </div>
        <div class="col-md-8">
            <div class="widget-container" style="min-height: 150px; padding-bottom: 5px;">
                <div class="heading">
                    <i class="icon-signal"></i>Current Skills
                </div>
                <div class="widget-content padded">
                    @foreach($skills as $skill)
                        <span class="btn btn-xs btn-default" style="font-size: 13px;">{{ $skill->itemname }} &nbsp;&nbsp;<a class="remove-skill" href="#" data-href="/removeSkill={{$skill->taskitem_code}}" title="Remove this skill" style="color: rgb(131, 131, 131)">x</a></span>
                    @endforeach
                    <hr/>
                    <form method="POST" action="/doEditSkillInfo" id="doEditSkillInfo">
                        <h4>Add a skill</h4>
                        <div class="col-md-2">
                            Category : 
                        </div>
                        <div class="col-md-10">
                            <select name="taskcategory" id="taskcategory" class="form-control">
                                @foreach($categories as $category)
                                    <option value="{{ $category->categorycode }}">{{ $category->categoryname }}</option>
                                @endforeach
                            </select><br/>
                        </div>
                        <div class="col-md-2">
                            Skill : 
                        </div>
                        <div class="col-md-10">
                            <select name="taskitems" id="taskitems" class="form-control">
                                @foreach($categorySkills as $skill)
                                    <option value="{{ $skill->itemcode }}">{{ $skill->itemname }}</option>
                                @endforeach
                            </select><br/>
                        </div>
                        <button type="submit" class="btn btn-success">Add Skill</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="widget-container small">
                @if(Auth::user()->profilePic == null)
                    <div class="heading">
                        <i class="icon-signal"></i>Please upload a profile picture
                    </div>
                    <div class="widget-content padded">
                        {{ Form::open(array('url' => '/uploadProfilePic', 'id' => 'uploadProfilePicForm', 'files' => 'true')) }}
                            <input type="file" name="profilePic" accept="image/*" class="form-control" /><br/>
                            <button type="submit" class="btn btn-success">Upload</button>
                        {{ Form::close() }}
                    </div>
                @else
                    <div class="widget-content padded">
                        <div class="heading">
                            <i class="glyphicon glyphicon-user"></i>{{ Auth::user()->fullName }}
                        </div>
                        <div class="thumbnail">
                            <a href="/editProfile"><img src="/public/{{ Auth::user()->profilePic }}" class="portrait"/></a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!--Current Skills : <br/>
    @foreach($skills as $skill)
        {{ $skill->itemname }} <a class="remove-skill" href="#" data-href="/removeSkill={{$skill->taskitem_code}}" title="Remove this skill">x</a><br/>
    @endforeach
    <hr/>
    <form method="POST" action="/doEditSkillInfo" id="doEditSkillInfo">
        <h4>Add a skill</h4>
        Category : <select name="taskcategory" id="taskcategory">
            @foreach($categories as $category)
                <option value="{{ $category->categorycode }}">{{ $category->categoryname }}</option>
            @endforeach
        </select><br/>
        Skill : <select name="taskitems" id="taskitems">
            @foreach($categorySkills as $skill)
                <option value="{{ $skill->itemcode }}">{{ $skill->itemname }}</option>
            @endforeach
        </select><br/>
        <button type="submit">Add Skill</button>
    </form>-->
@stop