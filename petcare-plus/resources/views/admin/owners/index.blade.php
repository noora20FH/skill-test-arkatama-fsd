@extends('layouts.bootstrap')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary text-white fw-bold">➕ Tambah Pemilik Baru</div>
            <div class="card-body">
                <form action="{{ route('owners.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Ahmad Subarjo" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nomor Telepon</label>
                        <input type="text" name="phone" class="form-control" placeholder="0812xxxx" required>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="is_verified" value="1" id="verifyCheck" checked>
                        <label class="form-check-label small" for="verifyCheck">Verifikasi Nomor Telepon</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Simpan Pemilik</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-bold d-flex justify-content-between">
                <span>📂 Daftar Pemilik (Owners)</span>
                <span class="badge bg-secondary">{{ $owners->count() }} Orang</span>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Telepon</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($owners as $owner)
                        <tr>
                            <td><strong>{{ $owner->name }}</strong></td>
                            <td>{{ $owner->phone }}</td>
                            <td>
                                @if($owner->is_verified)
                                    <span class="badge bg-success small">Verified</span>
                                @else
                                    <span class="badge bg-warning text-dark small">Unverified</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <form action="{{ route('owners.destroy', $owner->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus pemilik ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection