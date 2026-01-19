<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetCare+ Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .card { box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<div class="container py-5">
    <h2 class="mb-4 text-center fw-bold text-primary">🏥 PetCare+ Clinic Management</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Entri Data Hewan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('pets.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="owner_id" class="form-label">Pemilik (Verified Only)</label>
                            <select name="owner_id" id="owner_id" class="form-select" required>
                                <option value="" selected disabled>Pilih Pemilik...</option>
                                @foreach($owners as $owner)
                                    <option value="{{ $owner->id }}">
                                        {{ $owner->name }} ({{ $owner->phone }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="raw_data" class="form-label">Data Hewan</label>
                            <textarea name="raw_data" id="raw_data" rows="3" class="form-control" placeholder="Contoh: Milo Kucing 2Th 4.5kg" required></textarea>
                            <div class="form-text text-muted small">
                                Format: NAMA[spasi]JENIS[spasi]USIA[spasi]BERAT<br>
                                Contoh: <strong>Milo Kucing 2Th 4.5kg</strong>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Simpan Data</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Daftar Pasien Hewan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode Unik</th>
                                    <th>Pemilik</th>
                                    <th>Nama Hewan</th>
                                    <th>Jenis</th>
                                    <th>Usia (Th)</th>
                                    <th>Berat (Kg)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pets as $pet)
                                    <tr>
                                        <td><span class="badge bg-secondary">{{ $pet->code }}</span></td>
                                        <td>{{ $pet->owner->name }}</td>
                                        <td class="fw-bold">{{ $pet->name }}</td>
                                        <td>{{ $pet->type }}</td>
                                        <td>{{ $pet->age }}</td>
                                        <td>{{ $pet->weight }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-3">Belum ada data hewan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
