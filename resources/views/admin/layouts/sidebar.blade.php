<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('admin.home') }}" class="brand-link">
    {{-- <img src="#" alt="Logo" class="brand-image img-circle"
           style="border-radius: 0%;"> --}}
    <span class="brand-text font-weight-light">Hoodable</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div> -->

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="{{ route('admin.home') }}"
            class="nav-link {{ (request()->is('admin/dashboard*')) ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item has-treeview {{ (request()->is('admin/user*')) ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ (request()->is('admin/user*')) ? 'active' : '' }}">
            <i class="nav-icon fas fa-user"></i>
            <p>
              User Management
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.user.list') }}"
                class="nav-link {{ (request()->is('admin/user/list*')) ? 'active' : '' }}">
                <i class="nav-icon fas fa-users"></i>
                <p>Users</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.user.upgradeRequest.list') }}"
                class="nav-link {{ (request()->is('admin/user/upgradeRequest*')) ? 'active' : '' }}">
                <i class="nav-icon fas fa-clipboard-list"></i>
                <p>Upgrade Requests</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.spot.list') }}"
            class="nav-link {{ (request()->is('admin/spot/list*')) ? 'active' : '' }}">
            <i class="nav-icon fas fa-map"></i>
            <p>Spots</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.spot.event.list') }}"
            class="nav-link {{ (request()->is('admin/spot/event*')) ? 'active' : '' }}">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>Events</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.spot.promotion.list') }}"
            class="nav-link {{ (request()->is('admin/spot/promotion*')) ? 'active' : '' }}">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>Promotions</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.spot.competition.list') }}"
            class="nav-link {{ (request()->is('admin/spot/competition*')) ? 'active' : '' }}">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>Competitions</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="nav-icon fas fa-sign-out-alt">

            </i>
            {{ __('Logout') }}
          </a>
          <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>