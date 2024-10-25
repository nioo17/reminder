<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Navbar Search -->
    <li class="nav-item">
      <!--<a class="nav-link" href="#">
        <i class="fas fa-sign-out-alt"></i>
      </a>
        <form class="form-inline" method="POST" action="{{ route('logout') }}">
          @csrf
        </form>-->
      <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i></button>
      </form>
    </li>
  </ul>
</nav>