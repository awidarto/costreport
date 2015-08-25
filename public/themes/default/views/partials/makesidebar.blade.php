      <div class="sidebar">
        <div class="logopanel" style="padding:6px;padding-left:15px;padding-top:10px;">
          <h1>
            <a href="{{ URL::to('/') }}" style="background: url({{ URL::to('/') }}/images/lundin_top_logo.gif) no-repeat;background-size: 80px auto;">
            </a>
          </h1>
        </div>
        <div class="sidebar-inner">
          <ul class="nav nav-sidebar">
            <li class="nav-parent {{ hsa( array('gl','coa','') ) }} ">
              <a href=""><i class="fa fa-table"></i><span>Query</span><span class="fa arrow"></span></a>
              <ul class="children collapse">
                <li class="{{ sa('gl') }}" ><a href="{{ URL::to('gl') }}"> General Ledger</a></li>
                <li class="{{ sa('coa') }}" ><a href="{{ URL::to('coa') }}"> Chart Of Accounts</a></li>
                <li class="{{ sa('coa') }}" ><a href="{{ URL::to('accgroup') }}"> Account Groups</a></li>
              </ul>
            </li>
            <li class="nav-parent">
              <a href="{{ URL::to('employee') }}"><i class="icon-users"></i><span>Financial Statements</span> <span class="fa arrow"></span></a>
              <ul class="children collapse">
                <li><a href="{{ URL::to('tb') }}"> Trial Balance</a></li>
                <li><a href="{{ URL::to('is') }}"> Income Statement</a></li>
                <li><a href="{{ URL::to('bs') }}"> Balance Sheet</a></li>
                <li><a href="{{ URL::to('gl') }}"> General Ledger</a></li>
              </ul>
            </li>
            <li class="nav-parent">
              <a href="{{ URL::to('employee') }}"><i class="icon-users"></i><span>JV Reports</span> <span class="fa arrow"></span></a>
              <ul class="children collapse">
                <li><a href="{{ URL::to('jvsoab') }}"> Statement Acc. Balance</a></li>
                <li><a href="{{ URL::to('jvsoe') }}"> Summary of Expenditure</a></li>
                <li><a href="{{ URL::to('jvpar') }}"> Partner Advance Reconciliation</a></li>
              </ul>
            </li>
            <li class="nav-parent">
              <a href="#"><i class="fa fa-cog"></i><span>Performance Reports</span> <span class="fa arrow"></span></a>
              <ul class="children collapse">
                <li><a href="{{ URL::to('afelvltwo') }}"> AFE Report - Lvl 2</a></li>
                <li><a href="{{ URL::to('afelvlthree') }}"> AFE Report - Lvl 3</a></li>
                <li><a href="{{ URL::to('afegl') }}"> AFE Report - Ledger Query</a></li>
                <li><a href="{{ URL::to('cclvltwo') }}"> CC Report - Lvl 2</a></li>
                <li><a href="{{ URL::to('cclvlthree') }}"> CC Report - Lvl 3</a></li>
                <li><a href="{{ URL::to('ccgl') }}"> CC Report - Ledger Query</a></li>
              </ul>
            </li>
            <li class="nav-parent">
              <a href=""><i class="fa fa-cogs"></i><span>System </span><span class="fa arrow"></span></a>

                <ul class="children collapse">
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
          </ul>
          <!-- SIDEBAR WIDGET FOLDERS -->
          <div class="sidebar-widgets">
            <p class="menu-title widget-title">Folders <span class="pull-right"><a href="#" class="new-folder"> <i class="icon-plus"></i></a></span></p>
            <ul class="folders">
              <li>
                <a href="#"><i class="icon-doc c-primary"></i>My documents</a>
              </li>
              <li>
                <a href="#"><i class="icon-picture"></i>My images</a>
              </li>
              <li><a href="#"><i class="icon-lock"></i>Secure data</a>
              </li>
              <li class="add-folder">
                <input type="text" placeholder="Folder's name..." class="form-control input-sm">
              </li>
            </ul>
          </div>
          <div class="sidebar-footer clearfix">
            <a class="pull-left footer-settings" href="#" data-rel="tooltip" data-placement="top" data-original-title="Settings">
            <i class="icon-settings"></i></a>
            <a class="pull-left toggle_fullscreen" href="#" data-rel="tooltip" data-placement="top" data-original-title="Fullscreen">
            <i class="icon-size-fullscreen"></i></a>
            <a class="pull-left" href="#" data-rel="tooltip" data-placement="top" data-original-title="Lockscreen">
            <i class="icon-lock"></i></a>
            <a class="pull-left btn-effect" href="#" data-modal="modal-1" data-rel="tooltip" data-placement="top" data-original-title="Logout">
            <i class="icon-power"></i></a>
          </div>
        </div>
      </div>
