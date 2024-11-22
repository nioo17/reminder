@extends('components.app')

@section('title', 'Data Pengguna')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="card mb-3">
                <div class="card-header">
                    <form class="row row-cols-auto g-1">
                        <div class="col-11">
                            <button class="btn btn-primary">
                                <i class="bi bi-arrow-repeat" style="color: #ffffff;"></i> Refresh
                            </button>
                        </div>
                        <div class="col-1">
                            <a class="btn btn-secondary" data-toggle="modal" data-target="#addPenggunaModal">
                                <i class="fa fa-plus" style="color: #ffffff;"></i> Add
                            </a>
                        </div>
                    </form>
                    <div class="mt-2">
                    @if (session('success'))
                        <div class="alert alert-success mt-2">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped mt-2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Id Telegram</th>
                                    <th>Jabatan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($penggunas as $key => $pengguna)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $pengguna->nama }}</td>
                                        <td>{{ $pengguna->email }}</td>
                                        <td>{{ $pengguna->telegram }}</td>
                                        <td>{{ $pengguna->jabatan }}</td>
                                        <td>
                                            <a class="btn btn-warning" data-toggle="modal" data-target="#editPenggunaModal{{ $pengguna->id_pengguna }}">
                                                <i class="fa fa-pen" style="color: #ffffff;"></i>
                                            </a>
                                            <form method="POST" class="d-inline" action="{{ route('pengguna.destroy', $pengguna->id_pengguna) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" onclick="return confirm('Are you sure to delete?')">
                                                    <i class="fa fa-trash" style="color: #ffffff;"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Modal for Edit Pengguna -->
                                    <div class="modal fade" id="editPenggunaModal{{ $pengguna->id_pengguna }}" tabindex="-1" role="dialog" aria-labelledby="editPenggunaModalLabel{{ $pengguna->id_pengguna }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editEventModalLabel{{ $pengguna->id_pengguna }}">Edit Pengguna</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form method="POST" action="{{ route('pengguna.update', $pengguna->id_pengguna) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="nama">Nama</label>
                                                            <input type="text" name="nama" class="form-control" value="{{ $pengguna->nama }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">Pesan</label>
                                                            <input type="email" name="email" class="form-control" value="{{ $pengguna->email }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="telegram">Id Telegram</label>
                                                            <input type="text" name="telegram" class="form-control" value="{{ $pengguna->telegram }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="jabatan">Jabatan</label>
                                                            <select name="jabatan" class="form-control" required>
                                                                <option value="Karyawan" {{ $pengguna->jabatan == 'Karyawan' ? 'selected' : '' }}>Karyawan</option>
                                                                <option value="Atasan" {{ $pengguna->jabatan == 'Atasan' ? 'selected' : '' }}>Atasan</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal for Add Pengguna -->
<div class="modal fade" id="addPenggunaModal" tabindex="-1" role="dialog" aria-labelledby="addPenggunaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPenggunaModalLabel">Add Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('pengguna.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="telegram">Id Telegram</label>
                        <input type="text" name="telegram" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="jabatan">Jabatan</label>
                        <select name="jabatan" class="form-control" required>
                            <option value="Karyawan">Karyawan</option>
                            <option value="Atasan">Atasan</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
