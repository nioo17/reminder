@extends('components.app')

@section('title', 'Data Event')

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
                            <a class="btn btn-secondary" data-toggle="modal" data-target="#addEventModal">
                                <i class="fa fa-plus" style="color: #ffffff;"></i> Add
                            </a>
                        </div>
                    </form>

                    @if (session('success'))
                        <div class="alert alert-success mt-2">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped mt-2">
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
                            <tbody>
                                @foreach ($events as $key => $event)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $event->tanggal }}</td>
                                        <td>{{ $event->pesan }}</td>
                                        <td>
                                            @if ($event->gambar)
                                                <img src="{{ asset('images/poster' . $event->gambar) }}" alt="Event Image" width="100">
                                            @else
                                                <img src="{{ asset('images/poster/no_image.png') }}" alt="Default Image" width="100">
                                            @endif
                                        </td>
                                        <td>{{ ucfirst($event->kategori) }}</td>
                                        <td>
                                            <a class="btn btn-warning" data-toggle="modal" data-target="#editEventModal{{ $event->id_event }}">
                                                <i class="fa fa-pen" style="color: #ffffff;"></i>
                                            </a>
                                            <form method="POST" class="d-inline" action="{{ route('event.destroy', $event->id_event) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" onclick="return confirm('Are you sure to delete?')">
                                                    <i class="fa fa-trash" style="color: #ffffff;"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Modal for Edit Event -->
                                    <div class="modal fade" id="editEventModal{{ $event->id_event }}" tabindex="-1" role="dialog" aria-labelledby="editEventModalLabel{{ $event->id_event }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editEventModalLabel{{ $event->id_event }}">Edit Event</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form method="POST" action="{{ route('event.update', $event->id_event) }}" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="tanggal">Tanggal</label>
                                                            <input type="date" name="tanggal" class="form-control" value="{{ $event->tanggal }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="pesan">Pesan</label>
                                                            <textarea name="pesan" class="form-control" rows="3" required>{{ $event->pesan }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="kategori">Kategori</label>
                                                            <select name="kategori" class="form-control" required>
                                                                <option value="hariraya" {{ $event->kategori == 'hariraya' ? 'selected' : '' }}>Hari Raya</option>
                                                                <option value="harinasional" {{ $event->kategori == 'harinasional' ? 'selected' : '' }}>Hari Nasional</option>
                                                                <option value="harikeagamaan" {{ $event->kategori == 'harikeagamaan' ? 'selected' : '' }}>Hari Keagamaan</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="gambar">Gambar</label>
                                                            <input type="file" name="gambar" class="form-control" value="{{ $event->gambar }}">
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

<!-- Modal for Add Event -->
<div class="modal fade" id="addEventModal" tabindex="-1" role="dialog" aria-labelledby="addEventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEventModalLabel">Add Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('event.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="pesan">Pesan</label>
                        <textarea name="pesan" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select name="kategori" class="form-control" required>
                            <option value="hariraya">Hari Raya</option>
                            <option value="harinasional">Hari Nasional</option>
                            <option value="harikeagamaan">Hari Keagamaan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="gambar">Gambar</label>
                        <input type="file" name="gambar" class="form-control">
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
