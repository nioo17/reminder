<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>

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
  @include('components.navbar')
  
  @include('components.sidebar')
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-body p-0">
                <div id="calendar"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>

<script src="{{ asset('/templates/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('/templates/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/templates/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('/templates/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('/templates/plugins/fullcalendar/main.js') }}"></script>
<script>$.widget.bridge('uibutton', $.ui.button)</script>
<script src="{{ asset('/templates/plugins/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('/templates/plugins/sparklines/sparkline.js') }}"></script>
<script src="{{ asset('/templates/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('/templates/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<script src="{{ asset('/templates/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<script src="{{ asset('/templates/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('/templates/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('/templates/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('/templates/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<script src="{{ asset('/templates/dist/js/adminlte.js') }}"></script>
<script>
  $(function () {
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()

    var Calendar = FullCalendar.Calendar;
    var calendarEl = document.getElementById('calendar');

    var calendar = new Calendar(calendarEl, {
      headerToolbar: {
        left  : 'dayGridMonth,timeGridWeek,timeGridDay',
        center: 'title',
        right : 'prev,today,next',
      },
      buttonText: {
        dayGridMonth: 'Month',
        timeGridWeek: 'Week',
        timeGridDay: 'Day',
        today: 'Today',
      },

      themeSystem: 'bootstrap'

    });

    calendar.render();
  })
</script>
</body>
</html>