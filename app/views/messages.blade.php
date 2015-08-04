@extends('layouts.main')

@section('head')
Welcome to your dashboard!
@stop

@section('head-contents')
<script src="/js/jquery-1.11.0.min.js" type="text/javascript"></script>
<style>
    .chatItems {
        transition : 0.3s;
        margin-bottom: 0.2em;
        border: 1px solid #ECF0F1;
        border-radius: 0.3em;
        cursor: pointer;
        padding: 0.8em;
        background-color: #ECF0F1;
    }
    .chatItems:hover {
        /*box-shadow: 0 0 10px 0;*/

        border: 1px solid #BDC3C7;
        background-color: #ffffff;
    }
</style>
<script>
    $(document).ready(function(){
        setInterval(function(){
            var threads = $('.chatContact');
            for(var i=0; i < threads.size(); i++){
//                console.log(threads.eq(i).attr('data-threadcode'));
                if(threads.eq(i).attr('data-threadcode') != $('#currUserId').val()){
                    var code = threads.eq(i).attr('data-threadcode');
                    $.ajax({
                        type        :   'GET',
                        url         :   '/checkMsgs='+code,
                        success     :   function(data){
                            if(data['msgCount'] > 0){
                                $('.notifCount_'+data['threadCode']).empty().append(data['msgCount']).show();
                            }else{
                                $('.notifCount_'+data['threadCode']).hide();
                            }
                        },error      :   function(){
                            alert('ERR-500: Please check your network connectivity');
                        }
                    })
                }
            }
        }, 5000);

        setInterval(function(){
            var threadCode = $('#threadCode').val();
            if(threadCode != ''){
                $.ajax({
                    type        :   'GET',
                    url         :   '/checkMsgThread='+threadCode,
                    success     :   function(data){
                        $('.initChatBanner').remove();
                        if(data['msgCount'] > 0){
                            $.each(data['messages'], function(key, value){
                                $('#chatContent').append('<li><div class="bubble"><a class="user-name" target="_tab" href="/profile/'+value['id']+'">'+value['fullName']+'</a><p class="message">'+value['content']+'</p><p class="time"><strong>'+value['created_at']+'</strong></p></div></li>');
                            });
                        }
                    },error      :   function(){
//                        alert('ERR-500: Please check your network connectivity');
                    }
                })
            }
        }, 5000);

        $('#postMessage').keyup(function(){
            if($(this).val().length == 0){
                $('#postBtn').prop('disabled', true)
            }else{
                $('#postBtn').prop('disabled', false)
            }
        });

        $('#sendMsgForm').keypress(function(event){
//            return event.keyCode != 13;
            if(event.keyCode == 13){
                event.preventDefault();
                $('#postBtn').prop('disabled', true).empty().append('Posting..');
                $('#postMessage').prop('readonly', true);
                $.ajax({
                    type        :   'POST',
                    url         :   $('#sendMsgForm').attr('action'),
                    data        :   $('#sendMsgForm').serialize(),
                    success     :   function(data){
                        if(data == 'SUCCESS'){
                            var d = new Date();
                            var time = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate() + " " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
                            $('#chatContent').append('<li class="current-user"><div class="bubble"><a target="_tab" class="user-name" href="/profile/{{Auth::user()->id}}">{{ Auth::user()->fullName }}</a><p class="message">'+$('#postMessage').val()+'</p><p class="time"><strong>'+time+'</strong></p></div></li>');
                            $('#postMessage').prop('readonly', false).val('');
                            $('#postBtn').empty().append('Send');
                        }
                        $('.initChatBanner').remove();
                    },error      :   function(){
                        alert('ERR-500: Please check your network connectivity');
                        $('#postMessage').prop('readonly', false);
                        $('#postBtn').empty().append('Send');
                    }
                })
            }
        });

        $('#postBtn').click(function(){
            $(this).prop('disabled', true).empty().append('Posting..');
            $('#postMessage').prop('readonly', true);
            $.ajax({
                type        :   'POST',
                url         :   $('#sendMsgForm').attr('action'),
                data        :   $('#sendMsgForm').serialize(),
                success     :   function(data){
                    if(data == 'SUCCESS'){
                        var d = new Date();
                        var time = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate() + " " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
                        $('#chatContent').append('<li class="current-user"><div class="bubble"><a target="_tab" class="user-name" href="/profile/{{Auth::user()->id}}">{{ Auth::user()->fullName }}</a><p class="message">'+$('#postMessage').val()+'</p><p class="time"><strong>'+time+'</strong></p></div></li>');
                        $('#postMessage').prop('readonly', false).val('');
                        $('#postBtn').empty().append('Send');
                    }
                    $('.initChatBanner').remove();
                },error      :   function(){
                    alert('ERR-500: Please check your network connectivity');
                    $('#postMessage').prop('readonly', false);
                    $('#postBtn').empty().append('Send');
                }
            })
        });

        $('.chatContact').click(function(){
            $('#chatHeading').empty().append('<i class="icon-comments"></i> Chat with '+$(this).attr('data-fullname')+' for task '+$(this).attr('data-taskname'));
            $('#postMessage').prop('readonly', false);
            $('#threadCode').val($(this).attr('data-threadcode'));

            var chatContent = $('#chatContent');

            chatContent.empty();
            $.ajax({
                type        : 'GET',
                url         : '/getMessages/'+$(this).attr('data-threadcode'),
                success     : function(data){
                    if(data['msgCount'] == 0){
                        chatContent.empty().append('<div style="background-color: #3498DB; color:white; text-align: center; padding: 0.8em;" class="initChatBanner">Start chatting </div>');
                    }else{
                        var userId = $('#currUserId').val();
                        $.each(data['messages'], function(key, value){
                            if(parseInt(value['id']) != parseInt(userId)){
                                chatContent.append('<li><div class="bubble"><a class="user-name" target="_tab" href="/profile/'+value['id']+'">'+value['fullName']+'</a><p class="message">'+value['content']+'</p><p class="time"><strong>'+value['created_at']+'</strong></p></div></li>');
                            }else{
                                chatContent.append('<li class="current-user"><div class="bubble"><a target="_tab" class="user-name" href="/profile/'+value['id']+'">'+value['fullName']+'</a><p class="message">'+value['content']+'</p><p class="time"><strong>'+value['created_at']+'</strong></p></div></li>');
                            }
                        });
                    }
                },error     : function(){
                    alert('ERR-500: Please check your network connectivity');
                }
            })
        })
    });
</script>
@stop

@section('user-name')
{{ Auth::user()->firstName }} {{ Auth::user()->lastName }}
@stop

@section('contents')
<input type="hidden" name="currUserId" id="currUserId" value="{{Auth::user()->id}}"/>
<div class="container-fluid main-content">
    <div class="page-title">
        <h1>
            Chat
        </h1>
    </div>
    <div class="row">
        <!-- Conversation -->
        <div class="col-lg-12">
            <div class="widget-container scrollable chat chat-page">
                <div class="contact-list">
                    <div class="heading">
                        <!--                            Contacts (15)<i class="icon-plus pull-right"></i>-->
                        Contacts
                    </div>
                    <ul>
                        @if($threads->count() == 0)
                            <center><span style="font-size: 0.9em;">You currently have no contacts</span></center>
                        @endif
                        @foreach($threads as $tr)
                            @foreach(Thread::where('code', $tr->code)->whereNotIn('user_id', [Auth::user()->id])->orderBy('created_at', 'ASC')->get() as $innerTr)
                                <li>
                                    <a href="#" style="margin-bottom: 0;padding-bottom: 0;"
                                       data-taskname="{{ Task::where('id', $innerTr->task_id)->pluck('name') }}"
                                       data-threadcode="{{$innerTr->code}}"
                                       data-userid="{{$innerTr->user_id}}"
                                       data-fullname="{{ User::where('id', $innerTr->user_id)->pluck('fullName') }}"
                                       class="chatContact">
                                        {{ User::where('id', $innerTr->user_id)->pluck('fullName') }}
                                        <br/>
                                        <span style="font-size: 0.8em; color: #3498DB;">Task : {{ Task::where('id', $innerTr->task_id)->pluck('name') }}</span>
                                        <div class="fb-bar">
                                            <div id="msg-icon" class="msg-icon">
                                                <span id="notification_count" class="notifCount_{{$innerTr->code}}" style="display : none"></span>
                                                <!--<span id="notification_count">3</span>-->
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        @endforeach
                        <!--                            <li>-->
                        <!--                                <a href="#"><img width="30" height="30" src="images/avatar-female.png" />Gale Boetticher<i class="icon-circle text-warning"></i></a>-->
                        <!--                            </li>-->
                        <!--                            <li>-->
                        <!--                                <a href="#"><img width="30" height="30" src="images/avatar-female2.png" />Huell<i class="icon-circle text-muted"></i></a>-->
                        <!--                            </li>-->
                        <!--                            <li>-->
                        <!--                                <a href="#"><img width="30" height="30" src="images/avatar-male.jpg" />Ted Beneke<i class="icon-circle text-success"></i></a>-->
                        <!--                            </li>-->
                        <!--                            <li>-->
                        <!--                                <a href="#"><img width="30" height="30" src="images/avatar-female.png" />Bogdan Wolynetz<i class="icon-circle text-warning"></i></a>-->
                        <!--                            </li>-->
                    </ul>
                </div>
                <div class="heading" id="chatHeading">
                    <i class="icon-comments"></i> Select someone from your contacts to chat with.
<!--                    <i class="icon-comments"></i>Chat with <a href="#">John Smith</a><i class="icon-cog pull-right"></i><i class="icon-smile pull-right"></i>-->
                </div>
                <div class="widget-content padded" id="chatContentDiv">
                    <ul id="chatContent">
<!--                        <li>-->
<!--                            <div class="bubble">-->
<!--                                <a class="user-name" href="#">John Smith</a>-->
<!--                                <p class="message">-->
<!--                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.-->
<!--                                </p>-->
<!--                                <p class="time">-->
<!--                                    <strong>Today </strong>3:53 pm-->
<!--                                </p>-->
<!--                            </div>-->
<!--                        </li>-->
<!--                        <li class="current-user">-->
<!--                            <div class="bubble">-->
<!--                                <a class="user-name" href="#">Jane Smith</a>-->
<!--                                <p class="message">-->
<!--                                    Donec odio. Quisque volutpat mattis eros.-->
<!--                                </p>-->
<!--                                <p class="time">-->
<!--                                    <strong>Today </strong>3:53 pm-->
<!--                                </p>-->
<!--                            </div>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            <img width="30" height="30" src="images/avatar-male.jpg" />-->
<!--                            <div class="bubble">-->
<!--                                <a class="user-name" href="#">John Smith</a>-->
<!--                                <p class="message">-->
<!--                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.-->
<!--                                </p>-->
<!--                                <p class="time">-->
<!--                                    <strong>Today </strong>3:53 pm-->
<!--                                </p>-->
<!--                            </div>-->
<!--                        </li>-->
<!--                        <li class="current-user">-->
<!--                            <img width="30" height="30" src="images/avatar-female.jpg" />-->
<!--                            <div class="bubble">-->
<!--                                <a class="user-name" href="#">Jane Smith</a>-->
<!--                                <p class="message">-->
<!--                                    Donec odio. Quisque volutpat mattis eros.-->
<!--                                </p>-->
<!--                                <p class="time">-->
<!--                                    <strong>Today </strong>3:53 pm-->
<!--                                </p>-->
<!--                            </div>-->
<!--                        </li>-->
                    </ul>
                </div>
                <div class="post-message" style="padding-right: 0.8em;">
                    <form method="POST" action="/sendMsg" id="sendMsgForm">
                        <div class="col-md-11" style="padding: 0;">
                            <input class="form-control" placeholder="Write your message here…" type="text" name="postMessage" id="postMessage" required="required" readonly>
                            <input type="hidden" name="threadCode" id="threadCode" value="" />
                        </div>
                        <div class="col-md-1" style="padding: 0; padding-left: 0.6em;">
                            <button type="button" class="btn btn-primary btn-block" id="postBtn" disabled>Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--<div style="float: left; width: 20%; ">
    Chat with :
    @foreach($threads as $tr)
        @foreach(Thread::where('code', $tr->code)->whereNotIn('user_id', [Auth::user()->id])->orderBy('created_at', 'ASC')->get() as $innerTr)
            <div class="chatItems">
                {{ User::where('id', $innerTr->user_id)->pluck('fullName') }}
            </div>
        @endforeach
    @endforeach
</div>
<div style="float: left; width: 70%; border: 1px solid green; margin-left: 3em; height: 100%;">
</div>-->
@stop