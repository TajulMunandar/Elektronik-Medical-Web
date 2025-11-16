@extends('dashboard.main.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Rekam Medis</h1>
        <button class="btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#modalTambah">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Rekam Medis
        </button>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pasien</th>
                            <th>Petugas</th>
                            <th>Tanggal Periksa</th>
                            <th>Lokasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rekamMedis as $index => $rm)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $rm->pasien->user->name }}</td>
                                <td>{{ $rm->petugas->name }}</td>
                                <td>{{ $rm->tanggal_periksa }}</td>
                                <td>{{ ucfirst($rm->lokasi) }}</td>
                                <td>
                                    <button class="btn btn-info btn-sm" data-toggle="modal"
                                        data-target="#modalDetail{{ $rm->id }}">
                                        Detail
                                    </button>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#modalEdit{{ $rm->id }}">
                                        Edit
                                    </button>
                                    <form action="{{ route('rekam-medis.destroy', $rm->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin hapus?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>

                            {{-- Modal Detail --}}
                            <div class="modal fade" id="modalDetail{{ $rm->id }}" tabindex="-1" role="dialog"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Detail Rekam Medis</h5>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Pasien:</strong> {{ $rm->pasien->user->name }}</p>
                                            <p><strong>Petugas:</strong> {{ $rm->petugas->name }}</p>
                                            <p><strong>Tanggal Periksa:</strong> {{ $rm->tanggal_periksa }}</p>
                                            <p><strong>Keluhan:</strong> {{ $rm->keluhan }}</p>
                                            <p><strong>Diagnosa:</strong> {{ $rm->diagnosa }}</p>
                                            <p><strong>Catatan Tambahan:</strong> {{ $rm->catatan_tambahan ?? '-' }}</p>
                                            <p><strong>Lokasi:</strong> {{ ucfirst($rm->lokasi) }}</p>

                                            <hr>
                                            <h6>Data Medis</h6>
                                            <p><strong>Detak Jantung:</strong> {{ $rm->detak_jantung ?? '-' }}</p>
                                            <p><strong>Denyut Nadi:</strong> {{ $rm->denyut_nadi ?? '-' }}</p>
                                            <p><strong>Tekanan Darah:</strong> {{ $rm->tekanan_darah ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{-- Modal Edit --}}
                            <div class="modal fade" id="modalEdit{{ $rm->id }}" tabindex="-1" role="dialog"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form action="{{ route('rekam-medis.update', $rm->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Rekam Medis</h5>
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                {{-- Pasien --}}
                                                <div class="form-group">
                                                    <label>Pasien</label>
                                                    <select name="pasien_id" class="form-control" required>
                                                        @foreach ($pasiens as $p)
                                                            <option value="{{ $p->id }}"
                                                                {{ $p->id == $rm->pasien_id ? 'selected' : '' }}>
                                                                {{ $p->user->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                {{-- Petugas --}}
                                                <div class="form-group">
                                                    <label>Petugas</label>
                                                    <select name="petugas_id" class="form-control" required>
                                                        @foreach ($petugas as $pt)
                                                            <option value="{{ $pt->id }}"
                                                                {{ $pt->id == $rm->petugas_id ? 'selected' : '' }}>
                                                                {{ $pt->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                {{-- Tanggal Periksa --}}
                                                <div class="form-group">
                                                    <label>Tanggal Periksa</label>
                                                    <input type="date" name="tanggal_periksa" class="form-control"
                                                        value="{{ $rm->tanggal_periksa }}" required>
                                                </div>
                                                {{-- Keluhan --}}
                                                <div class="form-group">
                                                    <label>Keluhan</label>
                                                    <textarea name="keluhan" class="form-control" required>{{ $rm->keluhan }}</textarea>
                                                </div>
                                                {{-- Diagnosa --}}
                                                <div class="form-group">
                                                    <label>Diagnosa</label>
                                                    <textarea name="diagnosa" class="form-control" required>{{ $rm->diagnosa }}</textarea>
                                                </div>
                                                {{-- Catatan Tambahan --}}
                                                <div class="form-group">
                                                    <label>Catatan Tambahan</label>
                                                    <textarea name="catatan_tambahan" class="form-control">{{ $rm->catatan_tambahan }}</textarea>
                                                </div>
                                                {{-- Lokasi --}}
                                                <div class="form-group">
                                                    <label>Lokasi</label>
                                                    <select name="lokasi" class="form-control" required>
                                                        <option value="puskesmas"
                                                            {{ $rm->lokasi == 'puskesmas' ? 'selected' : '' }}>Puskesmas
                                                        </option>
                                                        <option value="rumah_sakit"
                                                            {{ $rm->lokasi == 'rumah_sakit' ? 'selected' : '' }}>Rumah
                                                            Sakit</option>
                                                    </select>
                                                </div>
                                                {{-- Tambahan Data Medis --}}
                                                <div class="form-group">
                                                    <label>Detak Jantung</label>
                                                    <input type="text" name="detak_jantung" class="form-control"
                                                        value="{{ $rm->detak_jantung }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Denyut Nadi</label>
                                                    <input type="text" name="denyut_nadi" class="form-control"
                                                        value="{{ $rm->denyut_nadi }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Tekanan Darah</label>
                                                    <input type="text" name="tekanan_darah" class="form-control"
                                                        value="{{ $rm->tekanan_darah }}">
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
            <form action="{{ route('rekam-medis.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Rekam Medis</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{-- Pasien --}}
                        <div class="form-group">
                            <label>Pasien</label>
                            <select name="pasien_id" class="form-control" required>
                                @foreach ($pasiens as $p)
                                    <option value="{{ $p->id }}">{{ $p->user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Petugas --}}
                        <div class="form-group">
                            <label>Petugas</label>
                            <select name="petugas_id" class="form-control" required>
                                @foreach ($petugas as $pt)
                                    <option value="{{ $pt->id }}">{{ $pt->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Tanggal Periksa --}}
                        <div class="form-group">
                            <label>Tanggal Periksa</label>
                            <input type="date" name="tanggal_periksa" class="form-control" required>
                        </div>
                        {{-- Keluhan --}}
                        <div class="form-group">
                            <label>Keluhan</label>
                            <textarea name="keluhan" class="form-control" required></textarea>
                        </div>
                        {{-- Diagnosa --}}
                        <div class="form-group">
                            <label>Diagnosa</label>
                            <textarea name="diagnosa" class="form-control" required></textarea>
                        </div>
                        {{-- Catatan Tambahan --}}
                        <div class="form-group">
                            <label>Catatan Tambahan</label>
                            <textarea name="catatan_tambahan" class="form-control"></textarea>
                        </div>
                        {{-- Lokasi --}}
                        <div class="form-group">
                            <label>Lokasi</label>
                            <select name="lokasi" class="form-control" required>
                                <option value="puskesmas">Puskesmas</option>
                                <option value="rumah_sakit">Rumah Sakit</option>
                            </select>
                        </div>
                        {{-- Tambahan Data Medis --}}
                        <div class="form-group">
                            <label>Detak Jantung</label>
                            <input type="text" name="detak_jantung" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Denyut Nadi</label>
                            <input type="text" name="denyut_nadi" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Tekanan Darah</label>
                            <input type="text" name="tekanan_darah" class="form-control">
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
