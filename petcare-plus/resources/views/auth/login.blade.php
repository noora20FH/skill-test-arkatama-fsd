<!DOCTYPE html>
<html>
<head>
    <title>Login PetCare+</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="card shadow border-0 p-4" style="width: 400px;">
        <h3 class="text-center mb-4 text-primary fw-bold">PetCare+ Login</h3>
        
        @if($errors->any())
            <div class="alert alert-danger p-2 small">Email atau password salah.</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Masuk</button>
        </form>
    </div>
</body>
</html>