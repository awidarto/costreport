<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Themes Lab - Creative Laborator</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta content="" name="description" />
        <meta content="themes-lab" name="author" />
        <link rel="shortcut icon" href="{{ URL::to('makeadmin') }}/assets/global/images/favicon.png">
        <link href="{{ URL::to('makeadmin') }}/assets/global/css/style.css" rel="stylesheet">
        <link href="{{ URL::to('makeadmin') }}/assets/global/css/ui.css" rel="stylesheet">
        <link href="{{ URL::to('makeadmin') }}/assets/global/plugins/bootstrap-loading/lada.min.css" rel="stylesheet">

        <style type="text/css">
            .account2 .account-info{
                background-color: #F4F4F4;
            }

            .account2 .form-footer{
                background-color: #FFF;
                border-top:none;
            }
        </style>

    </head>
    <body class="sidebar-top account2" data-page="login">
        <!-- BEGIN LOGIN BOX -->
        <div class="container" id="login-block">
            <i class="user-img icons-faces-users-03"></i>
            <div class="account-info">

                <img src="{{ URL::to('/') }}/images/lundin_top_logo.gif">

            </div>
            <div class="account-form">
                @yield('content')
            </div>

        </div>
        <!-- END LOCKSCREEN BOX -->
        <p class="account-copyright">
            <span>Copyright © 2015 </span><span>THEMES LAB</span>.<span>All rights reserved.</span>
        </p>
        <script src="{{ URL::to('makeadmin') }}/assets/global/plugins/jquery/jquery-1.11.1.min.js"></script>
        <script src="{{ URL::to('makeadmin') }}/assets/global/plugins/jquery/jquery-migrate-1.2.1.min.js"></script>
        <script src="{{ URL::to('makeadmin') }}/assets/global/plugins/gsap/main-gsap.min.js"></script>
        <script src="{{ URL::to('makeadmin') }}/assets/global/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="{{ URL::to('makeadmin') }}/assets/global/plugins/backstretch/backstretch.min.js"></script>
        <script src="{{ URL::to('makeadmin') }}/assets/global/plugins/bootstrap-loading/lada.min.js"></script>
        <script src="{{ URL::to('makeadmin') }}/assets/global/js/pages/login-v2.js"></script>

        <script type="text/javascript">
            $(document).ready(function(){
                $.backstretch(["{{ URL::to('makeadmin') }}/assets/global/images/gallery/login.jpg"],
                {
                    fade: 600,
                    duration: 4000
                });
            });
        </script>

    </body>
</html>