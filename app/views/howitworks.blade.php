<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Food is required">
    <meta name="author" content="EjLambo">

    <title>Proveek | How Proveek Works</title>

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
                    <li class="active">
                       <!--  <a class="" href="HowItWorks.html">How It Works</a> -->
                        {{ HTML::link('/howitworks', 'How It Works')}}

                    </li>

                    <li>
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
        </div>
        <!-- /.container-fluid -->
    </nav>

<!-- HEADER SECTION -->
    <header style="background-image:url(img/slideshow/03.jpg);">
        <div class="vegas.overlay" style="height:100%; width:100%; background-color: rgba(0,0,0,.5);">
            <div class="header-content">
                <div class="header-content-inner wow bounceIn" data-wow-delay=".1s">
                    <!-- <h1 style="margin-top:60px; margin-bottom:20px;">How Proveek Works</h1> -->
                    <!-- 16:9 aspect ratio -->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <div class="embed-responsive embed-responsive-16by9">
                                <!-- IFRAME -->
                                  <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/l0qWjHP1GQc"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
<!-- END OF -->

<!-- STEPS ON HOW IT WORKS -->
    <section id="works" style="border-bottom: 1px solid #222; padding-top:40px;padding-bottom:40px;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 text-center" style="border-right: 1px solid #ccc;">
                    <i class="fa fa-5x fa-user-plus wow bounceIn text-primary" data-wow-delay=".1s"></i>
                    <h2 class="section-heading">For Job Providers</h2>
                    <hr class="text-primary">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <img src="frontend/img/pw_jobP.jpg" class="wow fadeIn" data-wow-delay=".3s">
                    </div>
                    <div class="col-lg-1"></div>
                </div>
<!-- HARD CODE DESIGN DIAGRAM -->
                    <!-- <div class="col-lg-12">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-5 text-center" style="">
                            <i class="fa fa-5x fa-search wow bounceIn text-primary" data-wow-delay=".1s"></i>
                            <p>Browse</p>
                            <div class="text-center" style="padding-top:20px; padding-bottom:20px;">
                                <i class="fa fa-5x fa-long-arrow-down text-default"></i>
                            </div>

                            <i class="fa fa-5x fa-hand-pointer-o wow bounceIn text-primary" style="padding-top:15px;" data-wow-delay=".2s"></i>
                            <p>Choose</p>

                            <div class="text-center" style="padding-top:20px; padding-bottom:20px;">
                                <i class="fa fa-5x fa-level-up text-default rotate90deg"></i>
                            </div>
                        </div>
                        <div class="col-lg-5 text-center">
                            <i class="fa fa-5x fa-sticky-note-o wow bounceIn text-primary" data-wow-delay=".1s"></i>
                            <p>Post a Job</p>
                            <div class="text-center" style="padding-top:20px; padding-bottom:20px;">
                                <i class="fa fa-5x fa-long-arrow-down text-default"></i>
                            </div>

                            <i class="fa fa-5x fa-balance-scale wow bounceIn text-primary" style="padding-top:15px;" data-wow-delay=".2s"></i>
                            <p>Compare</p>

                            <div class="text-center" style="padding-top:20px; padding-bottom:20px;">
                                <i class="fa fa-5x fa-level-down text-default rotate90deg"></i>
                            </div>
                        </div>
                        <div class="col-lg-1"></div>
                    </div>
                </div>
                <div class="col-lg-8 col-lg-offset-2 col-sm-4 text-center">
                    <i class="fa fa-5x fa-users wow bounceIn text-primary"></i>
                    <p>Hire</p>
                </div> -->
<!-- END OF -->
                <div class="col-lg-6 text-center">
                    <i class="fa fa-5x fa-hand-paper-o wow bounceIn text-primary" data-wow-delay=".2s"></i>
                    <h2 class="section-heading">For Job Seekers</h2>
                    <hr class="text-primary">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <img src="frontend/img/pw_jobS.jpg" class="wow fadeIn" data-wow-delay=".4s">
                    </div>
                    <div class="col-lg-1"></div>
<!-- HARD CODE DESIGN DIAGRAM -->
                   <!--  <div class="col-lg-4">
                        <div class="text-center" style="padding-top:20px; padding-bottom:20px;">
                            <i class="fa fa-5x fa-level-up text-default rotate180deg"></i>
                        </div>
                        <i class="fa fa-5x fa-sticky-note-o wow bounceIn text-primary" data-wow-delay=".1s"></i>
                        <p>Wait for Job Offer</p>
                        <div class="text-center" style="padding-top:20px; padding-bottom:20px;">
                                <i class="fa fa-5x fa-level-up text-default rotate90deg"></i>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <i class="fa fa-5x fa-sign-in text-primary"></i>
                        <p>Sign up</p>
                    </div>

                    <div class="col-lg-4">
                        <div class="text-center" style="padding-top:20px; padding-bottom:20px;">
                            <i class="fa fa-5x fa-level-down text-default rotate360deg"></i>
                        </div>
                        <i class="fa fa-5x fa-legal wow bounceIn text-primary" data-wow-delay=".1s"></i>
                        <p>Bid for a Job</p>
                        <div class="text-center" style="padding-top:20px; padding-bottom:20px;">
                            <i class="fa fa-5x fa-level-down text-default rotate90deg"></i>
                        </div>
                    </div>
                    <div class="col-lg-12 text-center">
                        <i class="fa fa-5x fa-thumbs-o-up text-primary"></i>
                        <p>Get Hired</p>
                    </div> -->
<!-- END OF -->
                </div>
            </div>
        </div>
    </section>
<!-- END OF IT -->

<!-- POST A JOB -->
 <!-- 	<section class="bg-primary" style="background-image: url(img/header.jpg); background-position: center; background-attachment: fixed; -webkit-background-size: cover; -moz-background-size: cover; background-size: cover; -o-background-size: cover; border-top: 1px solid #222; border-bottom: 1px solid #222; padding-top: 40px; padding-bottom: 40px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                	<i class="fa fa-5x fa-plus wow bounceIn text-primary"></i>
                    <h2 class="section-heading">Can't find what you're looking for?</h2><br>
                    <a href="#" class="btn btn-default btn-lg" style="border-radius: 4em; width: 250px">Post a Job</a>
                    <!--<a href="#" class="btn btn-default btn-xl">Get Started!</a>
                </div>
            </div>
        </div>
    </section> -->
<!-- END OF POST A JOB -->

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
                                <li>
                                    
                                    <a href="#page-top" class="page-scroll">How It Works</a>
                                </li>
                                <li><a href="WhyProveek.html">Why Choose Proveek</a></li>
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
          slides: []
        });
    </script>
<!-- END OF HEADER SLIDER -->

</body>

</html>
