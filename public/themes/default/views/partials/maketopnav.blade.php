    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand {{ sa('dashboard') }} " href="{{ URL::to('/') }}">{{ Config::get('site.name')}}</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">

            @if(Ks::can('view','asset') || Ks::can('view','location') || Ks::can('view','rack') || Ks::can('view','devicetype'))

            <li class="dropdown  {{ sa('asset') }} {{ sa('rack') }} {{ sa('assetlocation') }} {{ sa('assettype') }} ">
                <a href="" data-toggle="dropdown" class="dropdown-toggle" role="button" aria-expanded="false"><i class="fa fa-cubes"></i> Advertising Assets <span class="caret"></span></a>
                <ul class="dropdown-menu pull-left">

                    @if(Ks::can('view','asset'))

                    <li class="{{ sa('asset') }}">
                        <a class="{{ sa('asset') }}" href="{{ URL::to('asset') }}"  ><i class="fa fa-th-list"></i> Ad Assets List</a>
                    </li>

                    @endif


                </ul>
            </li>
            @endif

            @if(Ks::can('view','advertiser'))

            <li class="dropdown">
                <a href="" data-toggle="dropdown" class="dropdown-toggle" role="button" aria-expanded="false">
                    <i class="fa fa-list"></i> Advertiser <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ sa('advertiser') }}">
                        <a class="{{ sa('advertiser') }}" href="{{ URL::to('advertiser') }}"  ><i class="fa fa-th-list"></i> Advertiser List</a>
                    </li>
                    <li class="{{ sa('shopcategory') }}">
                        <a class="{{ sa('shopcategory') }}" href="{{ URL::to('shopcategory') }}"  ><i class="fa fa-th-list"></i> Shop Category</a>
                    </li>
                </ul>
            </li>
            @endif


            @if(Ks::can('view','log'))

            <li class="dropdown">
                <a href="" data-toggle="dropdown" class="dropdown-toggle" role="button" aria-expanded="false">
                    <i class="fa fa-list"></i> Logs <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ sa('activity') }}" >
                        <a href="{{ URL::to('activity') }}" class="{{ sa('activity') }}" ><i class="fa fa-refresh"></i> Site Activity</a>
                    </li>
                    <li class="{{ sa('access') }}">
                        <a href="{{ URL::to('access') }}" class="{{ sa('access') }}" ><i class="fa fa-globe"></i> Site Access</a>
                    </li>
                    <li class="{{ sa('apiaccess') }}">
                        <a href="{{ URL::to('apiaccess') }}" class="{{ sa('apiaccess') }}" ><i class="fa fa-plug"></i> API Access</a>
                    </li>
                </ul>
            </li>

            @endif

            @if(Ks::can('view','report'))

            <li class="dropdown">
                <a href="" data-toggle="dropdown" class="dropdown-toggle" role="button" aria-expanded="false">
                    <i class="fa fa-bar-chart-o"></i> Reports <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ sa('stats') }}" >
                        <a href="{{ URL::to('stats') }}" class="{{ sa('stats') }}" ><i class="fa fa-check-square-o"></i> Global</a>
                    </li>
                    <li class="{{ sa('stats/merchant') }}" >
                        <a href="{{ URL::to('stats/merchant') }}" class="{{ sa('stats/merchant') }}" ><i class="fa fa-check-square-o"></i> By Merchant</a>
                    </li>
                </ul>
            </li>
            @endif

            @if(Ks::can('view','user'))

            <li class="dropdown {{ sa('user') }} {{ sa('usergroup') }} {{ sa('option') }}">
                <a href="#" data-toggle="dropdown" class="dropdown-toggle" role="button" aria-expanded="false">
                    <i class="fa fa-cogs"></i> System <span class="caret"></span>
                  </a>
                <ul class="dropdown-menu">
                    <li class="{{ sa('user') }}" >
                      <a href="{{ URL::to('user') }}" class="{{ sa('user') }}" ><i class="fa fa-group"></i> Users</a>
                    </li>
                    <li class="{{ sa('usergroup') }}">
                      <a href="{{ URL::to('usergroup') }}" class="{{ sa('usergroup') }}" ><i class="fa fa-group"></i> Roles</a>
                    </li>
                    <li class="{{ sa('option') }}">
                      <a href="{{ URL::to('option') }}" class="{{ sa('option') }}" ><i class="fa fa-wrench"></i> Options</a>
                    </li>
                </ul>
            </li>
            @endif

          </ul>

          @include('partials.identity')

        </div><!--/.nav-collapse -->
      </div>
    </nav>
