<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Food is required">
    <meta name="author" content="EjLambo">

    <title>Proveek | Why Choose Proveek</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="frontend/css/bootstrap.min.css" type="text/css">

    <!-- Custom Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="frontend/font-awesome/css/font-awesome.min.css" type="text/css">

    <!-- Plugin CSS -->
    <link rel="stylesheet" href="frontend/css/animate.min.css" type="text/css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="frontend/css/creative.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="frontend/css/vegas.css">
    <link rel="stylesheet" href="frontend/css/lightslider.css" type="text/css">
    <link rel="stylesheet" href="frontend/css/custom.css" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" type="image/x-icon" href="frontend/img/favicon.ico">

</head>

<body id="page-top">

    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="/home"><i class="fa fa-wrench"></i>  Proveek</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                       <!--  <a class="" href="HowItWorks.html">How It Works</a> -->
                        {{ HTML::link('/howitworks', 'How It Works')}}

                    </li>


                    <li class = "active">
                     <!--   <a class="" href="WhyProveek.html">Why Choose Proveek</a> -->
                         {{ HTML::link('/whychooseproveek', 'Why Choose Proveek')}}

                    </li>
                    <li>
                        <!-- <a class="" href="Pricing.html">Pricing</a> -->
                        {{ HTML::link('/pricing', 'Pricing')}}
                    </li>
                    <li>
                        <a class="" href="#">Login / Sign Up</span></a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
            <!--<div class="collapse navbar-collapse" style="background-color:rgba(255,255,255,.30); height: 25px; border-bottom-right-radius: 5px; border-bottom-left-radius: 5px">
                <ul class="nav navbar-nav">
                    <li>
                        <a class="page-scroll" href="#about" style="padding-top: 0;padding-bottom: 0">About</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#services" style="padding-top: 0;padding-bottom: 0">Services</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#contact" style="padding-top: 0;padding-bottom: 0">Contact</span></a>
                    </li>
                </ul>
            </div>-->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- HEADER SEARCH SECTION -->
    <header>
        <div class="header-content">
            <div class="vegas.overlay" style="height:100%; width:100%; opacity:1;background-color:rgba(0,0,0,.8);"></div>
                <div class="header-content-inner wow fadeIn" style="background-color:rgba(0,0,0,.5); padding-top: 35px; padding-bottom:15px; border-radius: 8px;">
                    <h1>Proveek</h1>
                    <hr>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    <div class="text-center div_header">
                    <a href="#next" class="page-scroll">
                        <i class="fa fa-4x fa-angle-down"></i>
                    </a>
                    </div>
                </div>
            </div>
    </header>
    <!-- END OF -->

    <section id="next" style="padding-top:40px; border-bottom:1px solid #222">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <i class="fa fa-5x fa-wrench wow bounceIn text-primary" data-wow-delay=".1s"></i>
                    <h2 class="section-heading">Why Choose Proveek?</h2>
                    <hr class="text-primary">

<!-- WHY PROVEEK? CONTAINER -->
                    <div class="col-lg-4">
                        <img src="frontend/img/header1.jpg" style="width:267px; height:150px;" class="wow bounceIn" data-wow-delay=".1s">
                        <p style="padding-top:20px">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                    <div class="col-lg-4">
                        <img src="frontend/img/slideshow/01.jpg" style="width:267px; height:150px;" class="wow bounceIn" data-wow-delay=".15s">
                        <p style="padding-top:20px">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                    <div class="col-lg-4">
                        <img src="frontend/img/slideshow/02.jpg" style="width:267px; height:150px;" class="wow bounceIn" data-wow-delay=".20s">
                        <p style="padding-top:20px">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>

                    <div class="col-lg-4">
                        <img src="frontend/img/slideshow/04.jpg" style="width:267px; height:150px;" class="wow bounceIn" data-wow-delay=".25s">
                        <p style="padding-top:20px">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                    <div class="col-lg-4">
                        <img src="frontend/img/slideshow/03.jpg" style="width:267px; height:150px;" class="wow bounceIn" data-wow-delay=".30s">
                        <p style="padding-top:20px">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                    <div class="col-lg-4">
                        <img src="frontend/img/slideshow/07.jpg" style="width:267px; height:150px;" class="wow bounceIn" data-wow-delay=".35s">
                        <p style="padding-top:20px">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
<!-- END OF -->

                    <i class="fa fa-5x fa-group wow bounceIn text-primary" data-wow-delay=".1s"></i>
                    <h2 class="section-heading">The Proveek Team</h2>
                    <hr class="text-primary">

<!-- PROVEEK TEAM CONTAINERS -->
                    <div class="col-lg-3">
                        <img src="frontend/img/team/01.png" style="width:150px; height:150px; border-radius:100%;" class="wow bounceIn" data-wow-delay=".1s">
                        <p style="padding-top:20px">Lambo</p>
                    </div>
                    <div class="col-lg-3">
                        <img src="frontend/img/team/02.jpg" style="width:150px; height:150px; border-radius:100%;" class="wow bounceIn" data-wow-delay=".2s">
                        <p style="padding-top:20px">Mark Dean Raymundo</p>
                    </div>
                    <div class="col-lg-3">
                        <img src="frontend/img/team/03.jpg" style="width:150px; height:150px; border-radius:100%;" class="wow bounceIn" data-wow-delay=".3s">
                        <p style="padding-top:20px">Boom - Boom</p>
                    </div>
                    <div class="col-lg-3">
                        <img src="frontend/img/team/04.jpg" style="width:150px; height:150px; border-radius:100%;" class="wow bounceIn" data-wow-delay=".4s">
                        <p style="padding-top:20px">Doge, very team, such grahpics, much pictures wow</p>
                    </div>

                    <div class="col-lg-3">
                        <img src="frontend/img/team/05.jpg" style="width:150px; height:150px; border-radius:100%;" class="wow bounceIn" data-wow-delay=".5s">
                        <p style="padding-top:20px">Batcat</p>
                    </div>
                    <div class="col-lg-3">
                        <img src="frontend/img/team/06.jpg" style="width:150px; height:150px; border-radius:100%;" class="wow bounceIn" data-wow-delay=".6s">
                        <p style="padding-top:20px">Emo Alpaca</p>
                    </div>
                    <div class="col-lg-3">
                        <img src="frontend/img/team/07.png" style="width:150px; height:150px; border-radius:100%;" class="wow bounceIn" data-wow-delay=".7s">
                        <p style="padding-top:20px">Edgaaarrr! - sup Bros!</p>
                    </div>
                    <div class="col-lg-3">
                        <img src="frontend/img/team/08.jpg" style="width:150px; height:150px; border-radius:100%;" class="wow bounceIn" data-wow-delay=".8s">
                        <p style="padding-top:20px">Jon Snow - "He knows nothing" and just to make this page cool</p>
                    </div>
<!-- END OF -->
                </div>
            </div>
        </div>
    </section>

<!-- FOOTER -->
    <section id="footer" style="padding-top:40px; padding-bottom:40px;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 text-center">
                    <div class="col-lg-4">
                        <div class="col-md-12 text-left div_footer">
                        <h2><i class="fa fa-wrench"></i>  Proveek</h2>
                            <ul>
                                <li><a href="index.html">Home</a></li>
                                <li><a href="HowItWorks.html">How It Works</a></li>
                                <li><a href="#page-top" class="page-scroll">Why Choose Proveek</a></li>
                                <li><a href="Pricing.html">Pricing</a></li>
                                <li><a href="faq.html">FAQ</a></li>
                                <li><a href="#page-top">Login / Sign Up</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-8 text-left feedback_footer">
                        <h2>Feedback</h2>
                        <p>We are like Jon Snow, we know nothing, so please send a feedback. Every feedback saves Emo Alpacas.</p>
                        <div class="col-lg-12" style="padding:0;">
                            <input type="email" placeholder="Email">
                        </div>
                        <div class="col-lg-12" style="padding:15px 0 0 0 ;">
                            <input type="text" placeholder="Message">
                        </div>
                        <div class="col-lg-12 text-right" style="padding:15px 0 0 0 ;">
                            <button type="button" class="btn btn-primary btn-md" style="width: 120px;border-radius: 4px;">Send</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-center" style="">
                    <h2 class="section-heading">Contact Us</h2>
                    <hr class="primary">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                    <div class="div_footer">
                        <a href="#"><i class="fa fa-facebook-square fa-3x wow bounceIn" data-wow-delay=".2s"></i></a>
                        <a href="#"><i class="fa fa-twitter-square fa-3x wow bounceIn" data-wow-delay=".3s"></i></a>
                        <a href="#"><i class="fa fa-instagram fa-3x wow bounceIn" data-wow-delay=".4s"></i></a>
                        <a href="#"><i class="fa fa-google-plus-square fa-3x wow bounceIn" data-wow-delay=".5s"></i></a>
                        <a href="#"><i class="fa fa-envelope-square fa-3x wow bounceIn" data-wow-delay=".6s"></i></a>
                    </div>
                    <p>2015  <i class="fa fa-copyright"></i>  Proveek Inc.</p>
                </div>
            </div>
        </div>
    </section>
<!-- END OF FOOTER -->

<!-- All scripts and plugin should be placed here so the page can load -->
<!-- jQuery -->
    <script src="frontend/js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
    <script src="frontend/js/bootstrap.min.js"></script>

<!-- Plugin JavaScript -->
    <script src="frontend/js/jquery.easing.min.js"></script>
    <script src="frontend/js/jquery.fittext.js"></script>
    <script src="frontend/js/wow.min.js"></script>
    <script src="frontend/js/vegas.js"></script>
<!-- Custom Theme JavaScript -->
    <script src="frontend/js/creative.js"></script>

    <script src="frontend/js/jquery.nicescroll.js"></script>

<!-- HTML SMOOTH MOUSEWHEEL SCROLLING -->
    <script>
    $(document).ready(

      function() { 

        $("html").niceScroll();

      }
    );
    </script>
<!-- END OF SMOOTH MOUSEWHEEL SCROLLING -->

<!-- FOR HEADER SLIDER -->
    <script>
        $('header').vegas({
          overlay: true,
          preload: true,
          preloadImage: true,
          transition: 'fade', 
          transitionDuration: 4000,
          delay: 10000,
          animation: 'random',
          shuffle: true,
          timer:false,
          animationDuration: 20000,
          slides: [
            { src: 'frontend/img/slideshow/01.jpg' },
            { src: 'frontend/img/slideshow/03.jpg' },
            { src: 'frontend/img/slideshow/05.jpg' },
            { src: 'frontend/img/slideshow/07.jpg' },
            { src: 'frontend/img/slideshow/02.jpg' },
            { src: 'frontend/img/slideshow/04.jpg' },
            { src: 'frontend/img/slideshow/06.jpg' },
          ]
        });
    </script>
<!-- END OF HEADER SLIDER -->

<!-- SLIDER PUBLIC SETTING -->
<!-- NOTE: For one slider only -->
	<script>

</body>

</html>
