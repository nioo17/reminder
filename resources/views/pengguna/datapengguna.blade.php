<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.2/css/dataTables.dataTables.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
  <title>!</title>
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

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4 shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="col-11 mt-1">
                          <h4 class="fw-bold">DATA PENGGUNA</h4>
                        </div>
                        <div class="col-1">
                          <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="bi bi-database-add"></i> ADD
                          </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="display">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>ID Telegram</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Pengguna</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="pengguna-form" method="post">
                               
                                <div class="row">
                                    <div class="col-lg">
                                        <label>Nama</label>
                                        <input type="text" name="nama" id="nama" class="form-control">
                                    </div>
                                    <div class="col-lg">
                                        <label>Email</label>
                                        <input type="email" name="email" id="email" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg">
                                        <label>ID Telegram</label>
                                        <input type="number" name="id_telegram" id="id_telegram" class="form-control">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" form="pengguna-form">Save</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="editModalLabel">Edit Pengguna</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                          <form id="edit-form" method="post">
                              <input type="hidden" id="edit-id" name="id">
                              <div class="row">
                                  <div class="col-lg">
                                      <label>Nama</label>
                                      <input type="text" id="edit-nama" name="nama" class="form-control">
                                  </div>
                                  <div class="col-lg">
                                      <label>Email</label>
                                      <input type="email" id="edit-email" name="email" class="form-control">
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-lg">
                                      <label>ID Telegram</label>
                                      <input type="number" id="edit-id_telegram" name="id_telegram" class="form-control">
                                  </div>
                              </div>
                          </form>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary" form="edit-form">Edit</button>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  </div>
</div>

<script>
  $(document).ready(function () {
      var table = $('#myTable').DataTable({
          "ajax": {
              "url": "{{ route('getall') }}",
              "type": "GET",
              "dataType": "json",
              "headers": {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              "dataSrc": function (response) {
                  if (response.status === 200) {
                      return response.employees;
                  } else {
                      return [];
                  }
              }
          },
          "columns": [
              { "data": "id_pengguna" },
              { "data": "nama" },
              { "data": "email" },
              { "data": "id_telegram" },
              {
                  "data": null,
                  "render": function (data, type, row) {
                      return '<a href="#" class="btn btn-sm btn-success edit-btn" data-id_pengguna="'+data.id+'" data-nama="'+data.nama+'" data-email="'+data.email+'" data-id_telegram="'+data.id_telegram+'">Edit</a> ' +
                      '<a href="#" class="btn btn-sm btn-danger delete-btn" data-id_pengguna="'+data.id+'">Delete</a>';
                  }
              }
          ]
      });

      $('#myTable tbody').on('click', '.edit-btn', function () {
                var id = $(this).data('id');
                var nama = $(this).data('nama');
                var email = $(this).data('email');
                var id_telegram = $(this).data('id_telegram');
              
                $('#edit-id').val(id);
                $('#edit-nama').val(name);
                $('#edit-email').val(email);
                $('#edit-id_telegram').val(id_telegram);
                $('#editModal').modal('show');
            });

            $('#pengguna-form').submit(function (e) {
                e.preventDefault();
                const penggunadata = new FormData(this);
                $.ajax({
                    url: '{{ route('store') }}',
                    method: 'post',
                    data: penggunadata,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status == 200) {
                            alert("Saved successfully");
                            $('#pengguna-form')[0].reset();
                            $('#exampleModal').modal('hide');
                            $('#myTable').DataTable().ajax.reload();
                        }
                    }
                });
            });
        });

        $('#edit-form').submit(function (e) {
                e.preventDefault();
                const penggunadata = new FormData(this);
                $.ajax({
                    url: '{{ route('update') }}',
                    method: 'POST',
                    data: penggunadata,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === 200) {
                            alert(response.message);
                            $('#edit-form')[0].reset();
                            $('#editModal').modal('hide');
                            $('#myTable').DataTable().ajax.reload();
                        } else {
                            alert(response.message);
                        }
                    }
                });
            });
        
            $(document).on('click', '.delete-btn', function() {
                var id = $(this).data('id');
                if (confirm('Are you sure you want to delete this data?')) {
                    $.ajax({
                        url: '{{ route('delete') }}',
                        type: 'DELETE',
                        data: {id: id},
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log(response); // Debugging: log the response
                            if (response.status === 200) {
                                alert(response.message); // Show success message
                                $('#myTable').DataTable().ajax.reload(); // Reload the table data
                            } else {
                                alert(response.message); // Show error message
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr); // Debugging: log the error
                            alert('Error: ' + error); // Show generic error message
                        }
                    });
                }
            });
</script>
</body>


      {{-- <div class="container-fluid">
          <div class="card mb-3">
            <div class="card-header">
                <form class="row row-cols-auto g-1">
                    <div class="col-11">
                        <button class="btn btn-primary"><i class="bi bi-arrow-repeat" style="color: #ffffff;"></i>Refresh</button>
                    </div>
                    <div class="col-1">
                        <a class="btn btn-secondary" href="#"><i class="fa fa-plus" style="color: #ffffff;"></i> Add</a>
                    </div>
                </form>
            </div>
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped m-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>ID Telegram</th>
                        <th>Action</th>
                    </tr>
                </thead>
                
                @foreach ($penggunas as $pengguna)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $pengguna->nama }}</td>
                        <td>{{ $pengguna->email }}</td>
                        <td>{{ $pengguna->id_telegram }}</td>
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
    {{-- @if ($penggunas->hasPages())
            <div class="card-footer">
                {{ $penggunas->links() }}
            </div>
     @endif --}}
          {{-- </div> --}}
      </div><!-- /.container-fluid -->
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
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
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
<script>
  $(document).ready( function () {
    $('#myTable').DataTable();
} );
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>