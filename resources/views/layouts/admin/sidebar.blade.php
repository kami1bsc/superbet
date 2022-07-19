<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
    <div class="sidebar-brand-icon">
        <!--<i class="fas fa-laugh-wink"></i>-->
        <!-- <img src = "http://dev.arfideveloper.com/xzit/public/app_icon.png" alt = "Logo" style = "width: 60px; height:45px;"> -->
    </div>
    <div class="sidebar-brand-text mx-3">{{ \Auth::user()->name }}</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="{{ route('admin.dashboard') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<!-- <div class="sidebar-heading">
    Interface
</div> -->

<!-- Nav Item - Pages Collapse Menu -->
<!-- <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-users"></i>
        <span>Users</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
           
            <a class="collapse-item" href="">Merchants</a>
            <a class="collapse-item" href="">Users</a>
        </div>
    </div>
</li> -->

<!-- Nav Item - Utilities Collapse Menu -->
<!-- <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
        aria-expanded="true" aria-controls="collapseUtilities">
        <i class="fas fa-fw fa-wrench"></i>
        <span>Utilities</span>
    </a>
    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Custom Utilities:</h6>
            <a class="collapse-item" href="utilities-color.html">Colors</a>
            <a class="collapse-item" href="utilities-border.html">Borders</a>
            <a class="collapse-item" href="utilities-animation.html">Animations</a>
            <a class="collapse-item" href="utilities-other.html">Other</a>
        </div>
    </div>
</li> -->

<!-- Divider -->
<!-- <hr class="sidebar-divider"> -->

<!-- Heading -->
<!-- <div class="sidebar-heading">
    Addons
</div> -->

<!-- Nav Item - Pages Collapse Menu -->
<!-- <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
        aria-expanded="true" aria-controls="collapsePages">
        <i class="fas fa-fw fa-folder"></i>
        <span>Pages</span>
    </a>
    <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Login Screens:</h6>
            <a class="collapse-item" href="login.html">Login</a>
            <a class="collapse-item" href="register.html">Register</a>
            <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
            <div class="collapse-divider"></div>
            <h6 class="collapse-header">Other Pages:</h6>
            <a class="collapse-item" href="404.html">404 Page</a>
            <a class="collapse-item" href="blank.html">Blank Page</a>
        </div>
    </div>
</li> -->

<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.users.index') }}">
        <i class="fas fa-fw fa-users"></i>
        <span>Users</span></a>
</li>

<!-- Nav Item - Charts -->
<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.categories.index') }}">
        <i class="fas fa-fw fa-list"></i>
        <span>Categories</span></a>
</li>

<!-- Nav Item - Tables -->
<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.albums.index') }}">
        <i class="fas fa-fw fa-list"></i>
        <span>Albums</span></a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.videos.index') }}">
        <i class="fas fa-fw fa-video"></i>
        <span>Videos</span></a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.majlis.index') }}">
        <i class="fas fa-fw fa-bullhorn"></i>
        <span>Majlis Updates</span></a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.banners.index') }}">
        <i class="fas fa-fw fa-bullhorn"></i>
        <span>Banners Images</span></a>
</li>

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-cogs"></i>
        <span>Screen Management</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
           
            <a class="collapse-item" href="{{ route('admin.top-section.index') }}">Top Section</a>
            <a class="collapse-item" href="{{ route('admin.month') }}">Month Name</a>
            <a class="collapse-item" href="{{ route('admin.month-kalam.index') }}">Month Kalam</a>
            <a class="collapse-item" href="{{ route('admin.trending.index') }}">Trending</a>
            <a class="collapse-item" href="{{ route('admin.nohay-singles.index') }}">Nohay Singles</a>
            <a class="collapse-item" href="{{ route('admin.manqabat-singles.index') }}">Manqabat Singles</a>
        </div>
    </div>
</li>

<!-- <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFour"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-cogs"></i>
        <span>Settings</span>
    </a>
    <div id="collapseFour" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">

            <a class="collapse-item" href="">Edit Profile</a>
            <a class="collapse-item" href="">Notifications</a>           
        </div>
    </div>
</li> -->

<!-- Divider -->
<!-- <hr class="sidebar-divider d-none d-md-block"> -->

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

<!-- Sidebar Message -->}
<!-- <div class="sidebar-card d-none d-lg-flex">
    <img class="sidebar-card-illustration mb-2" src="{{ asset('theme/img/undraw_rocket.svg')}}" alt="...">
    <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
    <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
</div> -->

</ul>
<!-- End of Sidebar -->