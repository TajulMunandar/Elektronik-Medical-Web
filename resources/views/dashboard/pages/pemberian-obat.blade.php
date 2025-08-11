@extends('dashboard.main.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Pemberian Obat</h1>
        <button class="btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#modalTambah">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Pemberian Obat
        </button>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Rekam Medis</th>
                            <th>Obat</th>
                            <th>Dosis</th>
                            <th>Frekuensi</th>
                            <th>Durasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pemberianObats as $index => $po)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $po->rekamMedis->pasien->user->name ?? '-' }}</td>
                                <td>{{ $po->obat->nama_obat ?? '-' }}</td>
                                <td>{{ $po->dosis }}</td>
                                <td>{{ $po->frekuensi }}</td>
                                <td>{{ $po->durasi }}</td>
                                <td>
                                    <button class="btn btn-info btn-sm" data-toggle="modal"
                                        data-target="#modalDetail{{ $po->id }}">
                                        Detail
                                    </button>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#modalEdit{{ $po->id }}">
                                        Edit
                                    </button>
                                    <form action="{{ route('pemberian-obat.destroy', $po->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin hapus data ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>

                            {{-- Modal Detail --}}
                            <div class="modal fade" id="modalDetail{{ $po->id }}" tabindex="-1" role="dialog"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Detail Pemberian Obat</h5>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Rekam Medis:</strong>
                                                {{ $po->rekamMedis->pasien->user->name ?? '-' }}</p>
                                            <p><strong>Obat:</strong> {{ $po->obat->nama_obat ?? '-' }}</p>
                                            <p><strong>Dosis:</strong> {{ $po->dosis }}</p>
                                            <p><strong>Frekuensi:</strong> {{ $po->frekuensi }}</p>
                                            <p><strong>Durasi:</strong> {{ $po->durasi }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Modal Edit --}}
                            <div class="modal fade" id="modalEdit{{ $po->id }}" tabindex="-1" role="dialog"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form action="{{ route('pemberian-obat.update', $po->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Pemberian Obat</h5>
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Rekam Medis</label>
                                                    <select name="rekam_medis_id" class="form-control" required>
                                                        @foreach ($rekamMedis as $rm)
                                                            <option value="{{ $rm->id }}"
                                                                {{ $rm->id == $po->rekam_medis_id ? 'selected' : '' }}>
                                                                {{ $rm->pasien->user->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Obat</label>
                                                    <select name="obat_id" class="form-control" required>
                                                        @foreach ($obats as $ob)
                                                            <option value="{{ $ob->id }}"
                                                                {{ $ob->id == $po->obat_id ? 'selected' : '' }}>
                                                                {{ $ob->nama_obat }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Dosis</label>
                                                    <input type="text" name="dosis" class="form-control"
                                                        value="{{ $po->dosis }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Frekuensi</label>
                                                    <input type="text" name="frekuensi" class="form-control"
                                                        value="{{ $po->frekuensi }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Durasi</label>
                                                    <input type="text" name="durasi" class="form-control"
                                                        value="{{ $po->durasi }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Tambah --}}
    <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('pemberian-obat.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Pemberian Obat</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Rekam Medis</label>
                            <select name="rekam_medis_id" class="form-control" required>
                                @foreach ($rekamMedis as $rm)
                                    <option value="{{ $rm->id }}">{{ $rm->pasien->user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Obat</label>
                            <select name="obat_id" class="form-control" required>
                                @foreach ($obats as $ob)
                                    <option value="{{ $ob->id }}">{{ $ob->nama_obat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Dosis</label>
                            <input type="text" name="dosis" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Frekuensi</label>
                            <input type="text" name="frekuensi" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Durasi</label>
                            <input type="text" name="durasi" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
@endsection
