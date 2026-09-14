<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover, maximum-scale=1">
    <meta name="theme-color" content="#008060">
    <title>Admin belépés | Radiátor Outlet</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body class="polaris-app d-flex align-items-center justify-content-center" style="min-height:100dvh;padding:1rem">
<div style="width:min(420px,100%)">
    <div class="p-card">
        <div class="text-center mb-3">
            <div class="polaris-logo mx-auto mb-2" style="width:48px;height:48px;font-size:1.2rem">R</div>
            <h1 class="h4 fw-bold mb-1">Belépés az adminba</h1>
            <p class="text-muted small mb-0">Radiátor Outlet Budapest</p>
        </div>
        @if(session('error'))<div class="polaris-banner danger">{{ session('error') }}</div>@endif
        <form method="post" action="{{ route('admin.login.submit') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">E-mail</label>
                <input type="email" name="email" class="form-control form-control-lg" required value="{{ old('email', config('shop.admin_email')) }}" autocomplete="username">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Jelszó</label>
                <input type="password" name="password" class="form-control form-control-lg" required autocomplete="current-password">
            </div>
            <button class="polaris-btn polaris-btn-primary w-100 justify-content-center" type="submit">Belépés</button>
        </form>
    </div>
</div>
</body>
</html>
