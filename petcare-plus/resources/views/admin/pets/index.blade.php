@extends('layouts.bootstrap')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0 fw-bold text-primary">📂 Manajemen Data Hewan</h5>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-sm">Tambah Hewan Baru</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Nama Hewan</th>
                        <th>Jenis</th>
                        <th>Pemilik</th>
                        <th>Fisik</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pets as $pet)
                    <tr>
                        <td><code class="fw-bold text-dark">{{ $pet->code }}</code></td>
                        <td class="fw-bold">{{ $pet->name }}</td>
                        <td><span class="badge bg-info text-dark">{{ $pet->type }}</span></td>
                        <td>{{ $pet->owner->name }}</td>
                        <td>{{ $pet->age }} Th / {{ $pet->weight }} Kg</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-outline-secondary">Edit</button>
                                <form action="{{ route('admin.pet.destroy', $pet->id) }}" method="POST" onsubmit="return confirm('Hapus data hewan ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection