@extends('layouts.bootstrap')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary text-white fw-bold">
                🐾 Registrasi Pasien Baru
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger small p-2">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                @endif
                
                @if(session('success'))
                    <div class="alert alert-success small p-2">{{ session('success') }}</div>
                @endif

                <form action="{{ route('admin.pet.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold">1. Pilih Pemilik (Verified)</label>
                        <select name="owner_id" class="form-select" required>
                            <option value="">-- Pilih Pemilik --</option>
                            @foreach($owners as $owner)
                                <option value="{{ $owner->id }}">{{ $owner->name }} ({{ $owner->phone }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">2. Data Hewan (Satu Baris)</label>
                        <input type="text" name="raw_data" class="form-control" placeholder="Contoh: Milo Kucing 2Th 4.5kg" required>
                        <div class="form-text text-muted small" style="font-size: 0.75rem;">
                            Format Wajib: NAMA[spasi]JENIS[spasi]USIA[spasi]BERAT
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Simpan Pasien</button>
                </form>
            </div>
        </div>
        
        <div class="card shadow-sm border-0">
            <div class="card-header bg-success text-white fw-bold">
                💉 Entri Pemeriksaan (Checkup)
            </div>
            <div class="card-body">
                <form action="{{ route('admin.checkup.store') }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label class="small text-muted">Pilih Pasien</label>
                        <select name="pet_id" class="form-select form-select-sm" required>
                            @foreach($pets as $p)
                                <option value="{{ $p->id }}">{{ $p->name }} - {{ $p->owner->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="small text-muted">Jenis Perawatan</label>
                        <select name="treatment_id" class="form-select form-select-sm" required>
                            @foreach($treatments as $t)
                                <option value="{{ $t->id }}">{{ $t->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="small text-muted">Catatan Medis</label>
                        <textarea name="notes" class="form-control form-control-sm" rows="2" placeholder="Suhu tubuh, keluhan, dll..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-success btn-sm w-100">Simpan Pemeriksaan</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
                <span>📂 Rekam Medis Klinik</span>
                <span class="badge bg-secondary">{{ $pets->count() }} Pasien</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered mb-0 align-middle small">
                        <thead class="table-light">
                            <tr>
                                <th>Kode & Pasien</th>
                                <th>Fisik</th>
                                <th>Riwayat Pemeriksaan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pets as $pet)
                            <tr>
                                <td>
                                    <div class="fw-bold text-primary">{{ $pet->name }} <span class="text-dark">({{ $pet->type }})</span></div>
                                    <div class="text-muted" style="font-size: 0.75rem;">
                                        Code: {{ $pet->code }}<br>
                                        Owner: {{ $pet->owner->name }}
                                    </div>
                                </td>
                                <td>
                                    {{ $pet->age }} Th<br>
                                    {{ $pet->weight }} Kg
                                </td>
                                <td>
                                    @if($pet->checkups->count() > 0)
                                        <ul class="ps-3 mb-0">
                                            @foreach($pet->checkups->take(3) as $c)
                                                <li>
                                                    <strong>{{ $c->treatment->name }}</strong>
                                                    <span class="text-muted">({{ $c->created_at->format('d/m/y') }})</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="badge bg-light text-muted border">Belum ada periksa</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('admin.pet.destroy', $pet->id) }}" method="POST" onsubmit="return confirm('Hapus data?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm px-2">🗑️</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center py-4">Belum ada data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection