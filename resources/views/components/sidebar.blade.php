<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../index3.html" class="brand-link">
      <img src="templates/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light"><b>Remind</b>Me</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="templates/dist/img/cat_ava.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>
      <!-- SidebarSearch Form -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">
            <!-- Dashboard -->
            <li class="nav-item">
                <a href="/dashboard" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Dashboard
                    </p>
                </a>
            </li>
            
            <!-- Data Master Dropdown -->
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-chart-bar"></i>
                    <p>
                        Data Master
                        <i class="right fas fa-angle-left"></i> <!-- Icon for dropdown indicator -->
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="event" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Data Events</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="pengguna" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Data Pengguna</p>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>    
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>