<!DOCTYPE html>
<html>
    <head>
        <title>
            @yield('head')
        </title>
        <link href="stylesheets/Lato.css" media="all" rel="stylesheet" type="text/css" />
        <link href="stylesheets/bootstrap.min.css" media="all" rel="stylesheet" type="text/css" />
        <link href="stylesheets/font-awesome.css" media="all" rel="stylesheet" type="text/css" />
        <link href="stylesheets/se7en-font.css" media="all" rel="stylesheet" type="text/css" />
        <link href="stylesheets/style.css" media="all" rel="stylesheet" type="text/css" />
        <link href="stylesheets/custom.css" media="all" rel="stylesheet" type="text/css" />
<!--        <script src="javascripts/jquery-1.10.2.min.js" type="text/javascript"></script>-->
        <script src="js/jquery-1.11.0.min.js" type="text/javascript"></script>
        <script src="javascripts/jquery-ui.js" type="text/javascript"></script>
        <script src="javascripts/bootstrap.min.js" type="text/javascript"></script>
        <script src="javascripts/modernizr.custom.js" type="text/javascript"></script>
<!--        <script src="javascripts/main.js" type="text/javascript"></script>-->
        <script src="js/taskminator.js" type="text/javascript"></script>
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
        @yield('head-contents')
    </head>
    <body class="login2">
        <!-- Login Screen -->
        <div class="login-wrapper">
            <!--<a href="/"><img width="100" height="30" src="images/logo-login%402x.png" /></a>-->

            @yield('content')
        </div>
        <!-- End Login Screen -->
    </body>
</html>