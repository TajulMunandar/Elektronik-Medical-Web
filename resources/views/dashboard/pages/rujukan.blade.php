@extends('dashboard.main.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Rujukan</h1>
        <button class="btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#modalTambah">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Rujukan
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
                            <th>Dari Faskes</th>
                            <th>Ke Faskes</th>
                            <th>Alasan Rujukan</th>
                            <th>Tanggal Rujukan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rujukans as $index => $r)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $r->rekamMedis->pasien->user->name ?? '-' }}</td>
                                <td>{{ ucfirst($r->dari_faskes) }}</td>
                                <td>{{ ucfirst($r->ke_faskes) }}</td>
                                <td>{{ $r->alasan_rujukan }}</td>
                                <td>{{ $r->tanggal_rujukan }}</td>
                                <td>
                                    <button class="btn btn-info btn-sm" data-toggle="modal"
                                        data-target="#modalDetail{{ $r->id }}">
                                        Detail
                                    </button>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#modalEdit{{ $r->id }}">
                                        Edit
                                    </button>
                                    <form action="{{ route('rujukan.destroy', $r->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin hapus data ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>

                            {{-- Modal Detail --}}
                            <div class="modal fade" id="modalDetail{{ $r->id }}" tabindex="-1" role="dialog"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Detail Rujukan</h5>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Rekam Medis:</strong>
                                                {{ $r->rekamMedis->pasien->user->name ?? '-' }}</p>
                                            <p><strong>Dari Faskes:</strong> {{ ucfirst($r->dari_faskes) }}</p>
                                            <p><strong>Ke Faskes:</strong> {{ ucfirst($r->ke_faskes) }}</p>
                                            <p><strong>Alasan Rujukan:</strong> {{ $r->alasan_rujukan }}</p>
                                            <p><strong>Tanggal Rujukan:</strong> {{ $r->tanggal_rujukan }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Modal Edit --}}
                            <div class="modal fade" id="modalEdit{{ $r->id }}" tabindex="-1" role="dialog"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form action="{{ route('rujukan.update', $r->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Rujukan</h5>
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
                                                                {{ $rm->id == $r->rekam_medis_id ? 'selected' : '' }}>
                                                                {{ $rm->pasien->user->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Dari Faskes</label>
                                                    <select name="dari_faskes" class="form-control" required>
                                                        <option value="puskesmas"
                                                            {{ $r->dari_faskes == 'puskesmas' ? 'selected' : '' }}>
                                                            Puskesmas</option>
                                                        <option value="rumah_sakit"
                                                            {{ $r->dari_faskes == 'rumah_sakit' ? 'selected' : '' }}>Rumah
                                                            Sakit</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Ke Faskes</label>
                                                    <select name="ke_faskes" class="form-control" required>
                                                        <option value="puskesmas"
                                                            {{ $r->ke_faskes == 'puskesmas' ? 'selected' : '' }}>Puskesmas
                                                        </option>
                                                        <option value="rumah_sakit"
                                                            {{ $r->ke_faskes == 'rumah_sakit' ? 'selected' : '' }}>Rumah
                                                            Sakit</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Alasan Rujukan</label>
                                                    <textarea name="alasan_rujukan" class="form-control" required>{{ $r->alasan_rujukan }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label>Tanggal Rujukan</label>
                                                    <input type="date" name="tanggal_rujukan" class="form-control"
                                                        value="{{ $r->tanggal_rujukan }}" required>
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
            <form action="{{ route('rujukan.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Rujukan</h5>
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
                            <label>Dari Faskes</label>
                            <select name="dari_faskes" class="form-control" required>
                                <option value="puskesmas">Puskesmas</option>
                                <option value="rumah_sakit">Rumah Sakit</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Ke Faskes</label>
                            <select name="ke_faskes" class="form-control" required>
                                <option value="puskesmas">Puskesmas</option>
                                <option value="rumah_sakit">Rumah Sakit</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Alasan Rujukan</label>
                            <textarea name="alasan_rujukan" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Rujukan</label>
                            <input type="date" name="tanggal_rujukan" class="form-control" required>
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
