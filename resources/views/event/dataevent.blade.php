<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Events</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('templates/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- fullCalendar -->
  <link rel="stylesheet" href="{{ asset('templates/plugins/fullcalendar/main.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('templates/dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('templates/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('templates/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('templates/plugins/summernote/summernote-bs4.min.css') }}">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  @include('components.navbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('components.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="card mb-3">
          <div class="card-header">
            <form class="row row-cols-auto g-1">
              <!--@if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
              @endif-->
              <div class="col-11">
                  <button class="btn btn-primary"><i class="bi bi-arrow-repeat" style="color: #ffffff;"></i>Refresh</button>
              </div>
              <div class="col-1">
                  <a class="btn btn-secondary" href="{{ route('createevent.create') }}"><i class="fa fa-plus" style="color: #ffffff;"></i> Add</a>
              </div>
          </form>
          <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped m-0">
              <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Pesan</th>
                    <th>Gambar</th>
                    <th>Kategori</th>
                    <th>Action</th>
                </tr>
            </thead>
            <?php $no = 1; ?>
                @foreach ($events as $event)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $event->tanggal }}</td>
                        <td>{{ $event->pesan }}</td>
                        <td>{{ $event->gambar }}</td>
                        <td>{{ $event->kategori }}</td>
                        <td>
                            <a class="btn btn-warning" href="#"><i class="fa fa-pen" style="color: #ffffff;"></i></a>
                            <form method="POST" class="d-inline" action="#">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger"
                                    onclick="return confirm('Are you sure to delete?')"><i class="fa fa-trash" style="color: #ffffff;"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
          </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      </div><!-- /.container-fluid -->
    </section>
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('/templates/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('/templates/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- jQuery UI -->
<script src="{{ asset('/templates/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/templates/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- fullCalendar 2.2.5 -->
<script src="{{ asset('/templates/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('/templates/plugins/fullcalendar/main.js') }}"></script>
<!-- jQuery -->
<script src="{{ asset('/templates/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('/templates/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('/templates/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('/templates/plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('/templates/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('/templates/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('/templates/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('/templates/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('/templates/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('/templates/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('/templates/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('/templates/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('/templates/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/templates/dist/js/adminlte.js') }}"></script>
</body>
</html>