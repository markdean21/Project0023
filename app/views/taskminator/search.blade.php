@extends('layouts.main')

@section('head')
    Taskminator - Task Search
@stop

@section('head-contents')
    <script src="/js/jquery-1.11.0.min.js" type="text/javascript"></script>
    <script>
        $(document).ready(function(){
            if($('#rateRange').val() != '0'){
                $('#rangeValue').prop('disabled', false);
            }else{
                $('#rangeValue').prop('disabled', true);
            }

            $('#rateRange').change(function(){
               if($(this).val() != '0'){
                   $('#rangeValue').prop('disabled', false);
               }else{
                   $('#rangeValue').prop('disabled', true);
               }
            });

            if($('#searchField').val() == 'city'){
//                        $('#searchCity-controls').fadeIn();
                $('#searchCity').prop('disabled', false);
            }
            $('#searchField').change(function(){
                if($(this).val() == 'city'){
//                        $('#searchCity-controls').fadeIn();
                    $('#searchCity').prop('disabled', false);
                }else{
                    $('#searchCity').prop('disabled', true);
                }
            });

            $('.cancel-task').click(function(){
                if(confirm('Are you sure you want to cancel your bid?')){
                    location.href = $(this).attr('data-href');
                }
            });

            $('#searchBtn').click(function(){
                var workingTime = '0',
                    searchField = '0',
                    searchCity  = '0',
                    searchWord  = '0',
                    rateRange   = '0',
                    rangeValue  = '0';

                if($('#workingtime').val() != ''){
                    workingTime = $('#workingtime').val();
                }

                if($('#searchField').val() != ''){
                    searchField = $('#searchField').val();
                }

                if($('#searchCity').val() != ''){
                    searchCity = $('#searchCity').val();
                }

                if($('#searchWord').val() != ''){
                    searchWord = $('#searchWord').val();
                }

                if($('#rateRange').val() != '0'){
                    rateRange = $('#rateRange').val();
                }

                if($('#rangeValue').val() != ''){
                    rangeValue = $('#rangeValue').val();
                }

                location.href = '/tskmntr/doTaskSearch='+workingTime+'='+searchField+'='+searchCity+'='+searchWord+'='+rateRange+'='+rangeValue;
            });
        })
    </script>
@stop

@section('user-name')
    {{ Auth::user()->firstName }} {{ Auth::user()->lastName }}
@stop

@section('contents')
    <div class="page-title">
<!--        <h1>-->
<!--            Task Search-->
<!--        </h1>-->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <ul class="breadcrumb">
                <li>
                    <a href="/"><i class="icon-home"></i></a>
                </li>
                <li class="active">
                    Search Task
                </li>
            </ul>
        </div>
        <div class="col-sm-3">
            <div class="widget-container fluid-height">
                <div class="widget-content">
                    <div class="panel-group" id="accordion">
<!--                        <form method="POST" action="/tskmntr/doTaskSearch" id="searchForm">-->
                            <div class="panel">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <a class="accordion-toggle" data-parent="#accordion" data-toggle="collapse" href="#collapseOne">
                                        <div class="caret pull-right"></div>
                                        Working Time</a>
                                    </div>
                                </div>
                                <div class="panel-collapse collapse in" id="collapseOne">
                                    <div class="panel-body">
                                        <select name="workingtime" id="workingtime" class="form-control">
                                            <option value="PTIME" <?php if(@$workingTime == 'PTIME'){ echo('selected'); } ?>>Part Time</option>
                                            <option value="FTIME" <?php if(@$workingTime == 'FTIME'){ echo('selected'); } ?>>Full Time</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="panel">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <a class="accordion-toggle" data-parent="#accordion" data-toggle="collapse" href="#collapseTwo">
                                        <div class="caret pull-right"></div>
                                        <span>Search By</span></a>
                                    </div>
                                </div>
                                <div class="panel-collapse collapse in" id="collapseTwo">
                                    <div class="panel-body">
                                        <select name="searchField" id="searchField" class="form-control">
                                            <option value="name"  <?php if(@$searchField == 'name'){ echo('selected'); } ?>>Task Name</option>
                                            <option value="city" <?php if(@$searchField == 'city'){ echo('selected'); } ?>>City</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="panel filter-categories">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <a class="accordion-toggle" data-parent="#accordion" data-toggle="collapse" href="#collapseThree">
                                        <div class="caret pull-right"></div>
                                        City</a>
                                    </div>
                                </div>
                                <div class="panel-collapse collapse in" id="collapseThree">
                                    <div class="panel-body">
                                        <div class="btn-group" data-toggle="buttons">
                                            <select name="searchCity" id="searchCity" class="form-control" disabled>
                                                @foreach($cities as $city)
                                                    <option value="{{ $city->citycode }}" <?php if(@$searchCity == $city->citycode){ echo('selected'); } ?>>{{ $city->cityname }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel filter-categories">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <a class="accordion-toggle" data-parent="#accordion" data-toggle="collapse" href="#collapseFour">
                                        <div class="caret pull-right"></div>
                                        Rate</a>
                                    </div>
                                </div>
                                <div class="panel-collapse collapse in" id="collapseFour">
                                    <div class="panel-body">
                                        <div class="btn-group" data-toggle="buttons">
                                            <select class="form-control" style="margin-bottom: 0.8em;" id="rateRange" name="rateRange">
                                                <option value="0" <?php if(@$rateRange == '0'){ echo('selected'); } ?>>Select range..</option>
                                                <option value="ABOVE" <?php if(@$rateRange == 'ABOVE'){ echo('selected'); } ?>>Above..</option>
                                                <option value="BELOW" <?php if(@$rateRange == 'BELOW'){ echo('selected'); } ?>>Below..</option>
                                            </select>

                                            <input value="{{@$rangeValue}}" type="text" name="rangeValue" id="rangeValue" class="form-control" placeholder="Enter amount (e.g. P12000)" disabled/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel filter-categories">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <a class="accordion-toggle" data-parent="#accordion" data-toggle="collapse" href="#collapseFour">
                                            <div class="caret pull-right"></div>
                                            Keyword</a>
                                    </div>
                                </div>
                                <div class="panel-collapse collapse in" id="collapseFour">
                                    <div class="panel-body">
                                        <div class="btn-group" data-toggle="buttons">
                                            <input value="<?php if(@$searchWord != 0){ echo($searchWord); } ?>" type="text" name="searchWord" id="searchWord" class="form-control" placeholder="Enter keyword"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel">
                                <div class="panel-collapse">
                                    <div class="panel-body">
                                        <button type="button" id="searchBtn" class="btn btn-block btn-success" style="text-align: center">Search</button>
                                    </div>
                                </div>
                            </div>
<!--                        </form>-->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-9">
            @if(@$tasks)
                @if($tasks->count() != 0)
                    @foreach($tasks as $task)
                        <div class="widget-container fluid-height padded">
                            <h3 style="color: blue; margin-bottom: 0; margin-top: 0.3em">{{ $task->name }}</h3>
                            <span style="color: grey; font-size: 1em">Description : {{ $task->description }}</span><br/>
                            <span style="color: grey; font-size: 1em">Deadline : {{ $task->deadline }}</span><br/>
                            <span style="color: grey; font-size: 1em">Created@ : {{ $task->created_at }}</span><br/>
                            <span style="color: grey; font-size: 1em">Location : {{ City::where('citycode', $task->city)->pluck('cityname') }}, {{ Barangay::where('bgycode', $task->barangay)->pluck('bgyname') }}</span><br/>
                            <span style="color: grey; font-size: 1em">Mode of payment : {{ $task->modeOfPayment }}</span><br/>
                            <span style="color: grey; font-size: 1em">Salary : P{{ $task->salary }}</span><br/>
                            <span style="color: grey; font-size: 1em">
                                Working Time :
                                @if($task->workTime == 'FTIME')
                                    Full Time
                                @else
                                    Part Time
                                @endif
                            </span><br/>
                            @foreach(User::where('id', $task->user_id)->get() as $user)
                                by <a target="_tab" href="/profile/{{ $user->id }}">{{ $user->fullName }}</a>
                            @endforeach
                            <hr/>
                            @if(TaskHasBidder::where('task_id', $task->id)->where('taskminator_id', Auth::user()->id)->count() != 0)
                               <div class="alert alert-success">
                                   Your Bid :<br/>
                                   Proposed Rate : {{ TaskHasBidder::where('task_id', $task->id)->where('taskminator_id', Auth::user()->id)->pluck('proposedRate') }}<br/>
                                   Message : {{ TaskHasBidder::where('task_id', $task->id)->where('taskminator_id', Auth::user()->id)->pluck('message') }}<br/>
                                   <span style="color: green">You have already made a bid for this task. Click <a href="/taskDetails_{{$task->id}}">here</a> for more details.</span>
                               </div>
                            @else
                                <br/><a href="/bid{{$task->workTime}}/{{ $task->id }}">Bid for task</a>
                            @endif
                        </div><br/>
                    @endforeach
                    <center>{{ $tasks->links() }}</center>
                @else
                    <div class="alert alert-danger" style="text-align: center">
                        <font>No results found</font>
                    </div>
                @endif
            @else
                <div class="well selected-filters" style="text-align: center">
                    Use filters on the left to filter tasks
                </div>
            @endif
        </div>
    </div>
@stop