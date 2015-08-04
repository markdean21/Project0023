<html>
    <head>
        <!--EXTERNAL CSS HERE -- START-->
        <!--EXTERNAL CSS HERE -- END-->

        <!--EXTERNAL JS HERE -- START-->
        {{ HTML::script('js/jquery-1.11.0.min.js') }}
        {{ HTML::script('js/taskminator.js') }}

        <!--EXTERNAL JS HERE -- END-->

        @yield('head')
    </head>
    <body>
        @yield('body')
    </body>
</html>