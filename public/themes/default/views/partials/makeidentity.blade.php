    <a href="#" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
        <img src="{{ Auth::user()->avatar }}" class="avatar img-circle" alt="user" title="user">
        <span class="username">{{ Auth::user()->fullname }}</span>
    </a>
    <ul class="dropdown-menu">
      <li>
        <a href="{{ URL::to('profile')}}"><i class="icon-user"></i><span>My Profile</span></a>
      </li>
      <li>
        <a href="#"><i class="icon-calendar"></i><span>My Calendar</span></a>
      </li>
      <li>
        <a href="#"><i class="icon-settings"></i><span>Account Settings</span></a>
      </li>
      <li>
       <a href="{{ URL::to('logout')}}"><i class="icon-logout"></i><span>Logout</span></a>
      </li>
    </ul>
