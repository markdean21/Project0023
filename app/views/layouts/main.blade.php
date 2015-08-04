<!DOCTYPE html>
<html>
    <head>
        <title>
            @yield('head')
        </title>
        {{ HTML::style('stylesheets/Lato.css') }}
        {{ HTML::style('stylesheets/bootstrap.min.css') }}
        {{ HTML::style('stylesheets/font-awesome.css') }}
        {{ HTML::style('stylesheets/se7en-font.css') }}
        {{ HTML::style('stylesheets/style.css') }}

        {{ HTML::style('stylesheets/isotope.css') }}
        {{ HTML::style('stylesheets/jquery.fancybox.css') }}
        {{ HTML::style('stylesheets/fullcalendar.css') }}
        {{ HTML::style('stylesheets/wizard.css') }}
        {{ HTML::style('stylesheets/select2.css') }}
        {{ HTML::style('stylesheets/morris.css') }}
        {{ HTML::style('stylesheets/datatables.css') }}
        {{ HTML::style('stylesheets/datepicker.css') }}
        {{ HTML::style('stylesheets/timepicker.css') }}
        {{ HTML::style('stylesheets/colorpicker.css') }}
        {{ HTML::style('stylesheets/bootstrap-switch.css') }}
        {{ HTML::style('stylesheets/daterange-picker.css') }}
        {{ HTML::style('stylesheets/typeahead.css') }}
        {{ HTML::style('stylesheets/summernote.css') }}
        {{ HTML::style('stylesheets/pygments.css') }}
        {{ HTML::style('stylesheets/custom.css') }}

        {{ HTML::script('js/jquery-1.11.0.min.js') }}
        {{ HTML::script('javascripts/jquery-ui.js') }}
        {{ HTML::script('javascripts/bootstrap.min.js') }}
        {{ HTML::script('javascripts/modernizr.custom.js') }}
        {{ HTML::script('js/taskminator.js') }}

        {{ HTML::script('javascripts/bootstrap.min.js') }}
        {{ HTML::script('javascripts/raphael.min.js') }}
        {{ HTML::script('javascripts/selectivizr-min.js') }}
        {{ HTML::script('javascripts/jquery.mousewheel.js') }}
        {{ HTML::script('javascripts/jquery.vmap.min.js') }}
        {{ HTML::script('javascripts/jquery.vmap.sampledata.js') }}
        {{ HTML::script('javascripts/jquery.vmap.world.js') }}
        {{ HTML::script('javascripts/jquery.bootstrap.wizard.js') }}
        {{ HTML::script('javascripts/fullcalendar.min.js') }}
        {{ HTML::script('javascripts/gcal.js') }}
        {{ HTML::script('javascripts/jquery.dataTables.min.js') }}
        {{ HTML::script('javascripts/datatable-editable.js') }}
        {{ HTML::script('javascripts/jquery.easy-pie-chart.js') }}
        {{ HTML::script('javascripts/excanvas.min.js') }}
        {{ HTML::script('javascripts/jquery.isotope.min.js') }}
        {{ HTML::script('javascripts/isotope_extras.js') }}
        {{ HTML::script('javascripts/modernizr.custom.js') }}
        {{ HTML::script('javascripts/jquery.fancybox.pack.js') }}
        {{ HTML::script('javascripts/select2.js') }}
        {{ HTML::script('javascripts/styleswitcher.js') }}
        {{ HTML::script('javascripts/wysiwyg.js') }}
        {{ HTML::script('javascripts/summernote.min.js') }}
        {{ HTML::script('javascripts/jquery.inputmask.min.js') }}
        {{ HTML::script('javascripts/jquery.validate.js') }}
        {{ HTML::script('javascripts/bootstrap-fileupload.js') }}
        {{ HTML::script('javascripts/bootstrap-datepicker.js') }}
        {{ HTML::script('javascripts/bootstrap-timepicker.js') }}
        {{ HTML::script('javascripts/bootstrap-colorpicker.js') }}
        {{ HTML::script('javascripts/bootstrap-switch.min.js') }}
        {{ HTML::script('javascripts/typeahead.js') }}
        {{ HTML::script('javascripts/daterange-picker.js') }}
        {{ HTML::script('javascripts/date.js') }}
        {{ HTML::script('javascripts/morris.min.js') }}
        {{ HTML::script('javascripts/skycons.js') }}
        {{ HTML::script('javascripts/fitvids.js') }}
        {{ HTML::script('javascripts/jquery.sparkline.min.js') }}
        {{ HTML::script('javascripts/main.js') }}
        {{ HTML::script('javascripts/respond.js') }}
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">

        @yield('head-contents')

        <style>
            .thumbnail {
                border: 1px solid #BDC3C7;
                border-radius: 0.3em;
                cursor: pointer;
                position: relative;
                width: 80px;
                height: 80px;
                overflow: hidden;
                /*float: left;*/
                margin-left: 20px;
                margin-top: 15px;
                margin-right: 1em;
                margin-bottom: 0em;
                /*-moz-box-shadow:    3px 3px 5px 6px #ccc;*/
                /*-webkit-box-shadow: 3px 3px 5px 6px #ccc;*/
                /*box-shadow: 0 8px 6px -6px black;*/
            }
            .thumbnail img {
                display: inline;
                position: absolute;
                left: 50%;
                top: 50%;
                height: 100%;
                width: auto;
                /*-webkit-transform: translate(-50%,-50%);*/
                /*-ms-transform: translate(-50%,-50%);*/
                transform: translate(-50%,-50%);
            }
            .thumbnail img.portrait {
                width: 100%;
                height: auto;
            }
        </style>
        <script>
            $(document).ready(function(){
                setInterval(function(){
                    $.ajax({
                        type        :   'GET',
                        url         :   '/checkMsgCount',
                        success     :   function(data){
                            if(data > 0){
                                $('#msg_count').empty().append(data).show();
                            }else{
                                $('#msg_count').empty().hide();
                            }
                        }
                    })
                }, 3000);

                setInterval(function(){
                    $.ajax({
                        type        :   'POST',
                        url         :   '/taskminator/notify',
                        success     :   function(data){
                            console.log(data);
                        }
                    })
                }, 10000);
            });

          $(function(){
            var thetitle = $('title').text();
            var totalNotif = parseInt($('#notification_count').text()) + parseInt($('#msg_count').text());
            $('.notif').click(function(){

              var countNotif = parseInt($('#notification_count').text());
              var newcountNotif = ++countNotif;
              totalNotif++;
              $('#notif-icon').removeClass('notif-icon').addClass('notif-iconh');
              $('#notification_count').text(newcountNotif).show();
              $('title').text('('+totalNotif+') '+thetitle);

                     jQuery('<div/>', {
                        id: 'notif-bot',
                        class : 'notif-bot alert alert-info',
                        text: 'You just got a notification!'
                        }).appendTo('.notif-bot-cnt')
                            .delay(5000)
                            .fadeOut();

            });

            $('.message').click(function(){

              var countNotif = parseInt($('#msg_count').text());
              var newcountNotif = ++countNotif;
              totalNotif++;
              $('#msg-icon').removeClass('msg-icon').addClass('msg-iconh');
              $('#msg_count').text(newcountNotif).show();
              $('title').text('('+totalNotif+') '+thetitle);

                     jQuery('<div/>', {
                        id: 'notif-bot',
                        class : 'notif-bot alert alert-success',
                        text: 'You just got a message!'
                        }).appendTo('.notif-bot-cnt')
                            .delay(5000)
                            .fadeOut();

            });

            /*$('#notif-icon').click(function(){
                $('this').removeClass('notif-iconh').addClass('notif-icon');
                $('#notification_count').text('0').hide();
                $('.notif-bot').hide();
                $('title').text(thetitle);
            });

            $('#msg-icon').click(function(){
                $('this').removeClass('msg-iconh').addClass('msg-icon');
                $('#msg_count').text('0').hide();
                $('.notif-bot').hide();
                $('title').text(thetitle);
            });*/

            $("#messageLink").click(function(){
              //$("#notificationContainer").fadeToggle(300);
              totalNotif = totalNotif - parseInt($('#msg_count').text());
              $('#msg_count').text('0').hide();
              $("#msg_count").fadeOut("slow");
              if(totalNotif!=0)
                $('title').text('('+totalNotif+') '+thetitle);
              else
                $('title').text(thetitle);
              //return false;
            });

            $("#notificationLink").click(function(){
              $("#notificationContainer").fadeToggle(300);
              totalNotif = totalNotif - parseInt($('#notification_count').text());
              $('#notification_count').text('0').hide();
              $("#notification_count").fadeOut("slow");
              if(totalNotif!=0)
                $('title').text('('+totalNotif+') '+thetitle);
              else
                $('title').text(thetitle);
              return false;
            });

            //Document Click
            $(document).click(function(){
              $("#notificationContainer").hide();
            });

            //Popup Click
            $("#notificationContainer").click(function(){
              return false;
            });
          });
         </script>
    </head>
    <body>
        <div class="modal-shiftfix">
          <!-- Navigation -->
          <div class="navbar navbar-fixed-top scroll-hide">
            <div class="container-fluid top-bar">
                <div class="pull-right col-lg-6">
                    <ul class="nav navbar-nav pull-right col-lg-12">
                        <li class="dropdown">
                            <a href="/logout">Logout</a>
                        </li>
                        <li class="user hidden-xs"><a href="/editProfile">
                            @if(Auth::user()->profilePic)
                                <img width="34" height="34" src="/public/{{ Auth::user()->profilePic }}" />@yield('user-name')</a>
                            @else
                                <img width="34" height="34" src="/images/default_profile_pic.png" />@yield('user-name')</a>
                            @endif
                            <!--<ul class="dropdown-menu">
                                <li><a href="#">
                                    <i class="icon-user"></i>My Account</a>
                                </li>
                                <li><a href="#">
                                    <i class="icon-gear"></i>Account Settings</a>
                                </li>
                                <li><a href="login1.html">
                                    <i class="icon-signout"></i>Logout</a>
                                </li>
                            </ul>-->
                        </li>
                        <li class="dropdown notifications hidden-xs">
                          <a class="dropdown-toggle" data-toggle="dropdown" href="#"  id="messageLink"><span aria-hidden="true" class="se7en-envelope" onclick="location.href='/messages'"></span></a>
                          <div class="sr-only">
                            Messages
                          </div>
                          <div class="fb-bar-msg">
                              <div id="msg-icon" class="msg-icon">
                                  @if(User::getMessages()->count() > 0)
                                      <id id="msg_count" style="">{{ User::getMessages()->count() }}</id>
                                  @else
                                      <id id="msg_count" style="display: none;"></id>
                                  @endif
                                <!--<span id="notification_count">3</span>-->
                              </div>
                            </div>
                        </li>
                        <li class="dropdown messages hidden-xs">
<!--                            <a class="dropdown-toggle" data-toggle="dropdown" href="/tskmntr/messages"><span aria-hidden="true" class="se7en-envelope"></span>-->
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"  id="notificationLink"><span aria-hidden="true" class="se7en-flag"></span></a>
                            <div class="sr-only">
                                Notifications
                            </div>
                            <div class="fb-bar">
                              <div id="notif-icon" class="notif-icon">
                                  @if(User::getNotif()->count() > 0)
                                    <id id="notification_count" style="">{{ User::getNotif()->count() }}</id>
                                  @else
                                      <id id="notification_count" style="display: none;"></id>
                                  @endif
                                <!--<span id="notification_count">3</span>-->
                              </div>
                            </div>
                            <div id="notificationContainer" class="messages">
                            <div id="notificationTitle">Notifications</div>
                            <div id="notificationsBody" class="notifications">
                                <ul class="dropdown-msg">
                                @if(User::getNotif()->count() > 0)
                                    @foreach(User::getNotif() as $notif)
                                      <li onclick="location.href='{{$notif->notif_url}}'">
                                          <a href="{{$notif->notif_url}}">
                                              {{ $notif->content }}
                                          </a>
                                      </li>
                                    @endforeach
                                @else
                                    <center><i>You have no notifications yet</i></center>
                                @endif
<!--                                <ul class="dropdown-msg">-->
<!--                                  <li><a href="#">-->
<!--                                    <img width="34" height="34" src="images/avatar-male2.png" />Could we meet today? I wanted...</a>-->
<!--                                  </li>-->
<!--                                  <li><a href="#">-->
<!--                                    <img width="34" height="34" src="images/avatar-female.png" />Important data needs your analysis...</a>-->
<!--                                  </li>-->
<!--                                  <li><a href="#">-->
<!--                                    <img width="34" height="34" src="images/avatar-male2.png" />Buy Se7en today, it's a great theme...</a>-->
<!--                                  </li>-->
                                </ul>
                            </div>
                            <div id="notificationFooter"><a href="/showAllNotif" onclick="location.href='/showAllNotif'">See All</a></div>
                            </div>
                        </li>
                    </ul>
                </div>
                <button class="navbar-toggle"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><a class="logo" href="/">TASKminator</a>
                <form class="navbar-form form-inline col-lg-2 hidden-xs">
                    <input class="form-control" placeholder="Search" type="text">
                </form>
            </div>
            <!--<div class="container-fluid main-nav clearfix">
              <div class="nav-collapse">
                <ul class="nav">
                  <li>
                    <a class="current" href="/"><span aria-hidden="true" class="se7en-home"></span>Dashboard</a>
                  </li>
                  <li><a href="social.html">
                    <span aria-hidden="true" class="se7en-feed"></span>Social Feed</a>
                  </li>
                  <li class="dropdown"><a data-toggle="dropdown" href="#">
                    <span aria-hidden="true" class="se7en-star"></span>Features<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li>
                        <a href="buttons.html">Buttons</a>
                      </li>
                      <li>
                        <a href="fontawesome.html">Font Awesome Icons</a>
                      </li>
                      <li><a href="glyphicons.html">
                        <span class="notifications label label-warning">New</span>
                        <p>
                          Glyphicons
                        </p></a>

                      </li>
                      <li>
                        <a href="components.html">Components</a>
                      </li>
                      <li>
                        <a href="widgets.html">Widgets</a>
                      </li>
                      <li>
                        <a href="typo.html">Typography</a>
                      </li>
                      <li>
                        <a href="grid.html">Grid Layout</a>
                      </li>
                    </ul>
                  </li>
                  <li class="dropdown"><a data-toggle="dropdown" href="#">
                    <span aria-hidden="true" class="se7en-forms"></span>Forms<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li><a href="form-components.html">
                        <span class="notifications label label-warning">New</span>
                        <p>
                          Form Components
                        </p></a>

                      </li>
                      <li>
                        <a href="form-advanced.html">Advanced Forms</a>
                      </li>
                    </ul>
                  </li>
                  <li class="dropdown"><a data-toggle="dropdown" href="#">
                    <span aria-hidden="true" class="se7en-tables"></span>Tables<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li>
                        <a href="tables.html">Basic tables</a>
                      </li>
                      <li>
                        <a href="datatables.html">DataTables</a>
                      </li>
                      <li><a href="datatables-editable.html">
                        <div class="notifications label label-warning">
                          New
                        </div>
                        <p>
                          Editable DataTables
                        </p></a>

                      </li>
                    </ul>
                  </li>
                  <li><a href="charts.html">
                    <span aria-hidden="true" class="se7en-charts"></span>Charts</a>
                  </li>
                  <li class="dropdown"><a data-toggle="dropdown" href="#">
                    <span aria-hidden="true" class="se7en-pages"></span>Pages<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li><a href="chat.html">
                        <span class="notifications label label-warning">New</span>
                        <p>
                          Chat
                        </p></a>

                      </li>
                      <li>
                        <a href="calendar.html">Calendar</a>
                      </li>
                      <li><a href="timeline.html">
                        <span class="notifications label label-warning">New</span>
                        <p>
                          Timeline
                        </p></a>

                      </li>
                      <li><a href="login1.html">
                        <span class="notifications label label-warning">New</span>
                        <p>
                          Login 1
                        </p></a>

                      </li>
                      <li>
                        <a href="login2.html">Login 2</a>
                      </li>
                      <li><a href="signup1.html">
                        <span class="notifications label label-warning">New</span>
                        <p>
                          Sign Up 1
                        </p></a>

                      </li>
                      <li>
                        <a href="signup2.html">Sign Up 2</a>
                      </li>
                      <li><a href="invoice.html">
                        <span class="notifications label label-warning">New</span>
                        <p>
                          Invoice
                        </p></a>

                      </li>
                      <li><a href="faq.html">
                        <span class="notifications label label-warning">New</span>
                        <p>
                          FAQ
                        </p></a>

                      </li>
                      <li>
                        <a href="filters.html">Filter Results</a>
                      </li>
                      <li>
                        <a href="404-page.html">404 Page</a>
                      </li>
                    </ul>
                  </li>
                  <li><a href="gallery.html">
                    <span aria-hidden="true" class="se7en-gallery"></span>Gallery</a>
                  </li>
                </ul>
              </div>
            </div>-->
          </div>
          <!-- End Navigation -->
            <div class="container-fluid main-content">

                            @yield('contents')
            </div>

<!--            <div class="row">-->
<!--              <a class="notif btn btn-success">notify me</a>-->
<!--              <a class="message btn btn-info">message me</a>-->
<!--            </div>-->


            <div class="notif-bot-cnt padded col-md-3"></div>


    </body>
</html>