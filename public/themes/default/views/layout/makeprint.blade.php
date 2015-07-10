<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="admin-themes-lab">
    <meta name="author" content="themes-lab">
    <link rel="shortcut icon" href="../assets/global/images/favicon.png" type="image/png">
    <title>{{ Config::get('site.name') }}</title>

    @include('layout.css')
    <link href="{{ URL::to('makeadmin') }}/assets/global/css/style.css" rel="stylesheet">
    <link href="{{ URL::to('makeadmin') }}/assets/global/css/theme.css" rel="stylesheet">
    <link href="{{ URL::to('makeadmin') }}/assets/global/css/ui.css" rel="stylesheet">

    <link href="{{ URL::to('makeadmin') }}/assets/admin/md-layout4/material-design/css/material.css" rel="stylesheet">
    <link href="{{ URL::to('makeadmin') }}/assets/admin/md-layout4/css/layout.css" rel="stylesheet">


    <script src="{{ URL::to('makeadmin') }}/assets/global/plugins/modernizr/modernizr-2.6.2-respond-1.1.0.min.js"></script>

    <script src="{{ URL::to('makeadmin')}}/assets/global/plugins/jquery/jquery-1.11.1.min.js"></script>
    <script src="{{ URL::to('makeadmin')}}/assets/global/plugins/jquery/jquery-migrate-1.2.1.min.js"></script>
    <script src="{{ URL::to('makeadmin')}}/assets/global/plugins/jquery-ui/jquery-ui-1.11.2.min.js"></script>

    <script type="text/javascript">
      var base = '{{ URL::to('/') }}/';
    </script>

    <style type="text/css">

      label{
        margin-top: 12px !important;

      }

    </style>

  </head>
  <body class="sidebar-top fixed-topbar fixed-sidebar theme-sdtl color-default">
    <!--[if lt IE 7]>
    <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <div class="main-content">
        <div class="header">
          <h2>{{ boldfirst($title) }}</h2>
        </div>
        <div class="row">
          <div class="col-lg-12 portlets">
            @yield('content')
          </div>
        </div>
    </div>

  </body>
</html>