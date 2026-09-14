@extends('layouts.app')

@section('title', 'Megrendelés | Radiátor Outlet Budapest')

@section('content')
<div class="container py-4">
    <h1 class="section-title"><i class="bi bi-clipboard-check me-2"></i>Megrendelés</h1>
    <p class="section-sub">Adja meg az adatait. Online bankkártyás fizetés jelenleg nem szükséges.</p>

    <div class="row g-4">
        <div class="col-lg-7">
            <form method="post" action="{{ route('checkout.store') }}" class="admin-card">
                @csrf
                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-person text-primary me-1"></i> Név</label>
                    <input type="text" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror" placeholder="Pl. Kovács Péter" value="{{ old('customer_name') }}" required>
                    @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-telephone text-primary me-1"></i> Telefonszám</label>
                    <input type="text" name="customer_phone" class="form-control @error('customer_phone') is-invalid @enderror" placeholder="+36 20 123 4567" value="{{ old('customer_phone') }}" required>
                    @error('customer_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-envelope text-primary me-1"></i> E-mail cím</label>
                    <input type="email" name="customer_email" class="form-control @error('customer_email') is-invalid @enderror" placeholder="pelda@email.hu" value="{{ old('customer_email') }}" required>
                    @error('customer_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-geo-alt text-primary me-1"></i> Budapesti szállítási cím</label>
                    <input type="text" name="shipping_address" class="form-control @error('shipping_address') is-invalid @enderror" placeholder="Irányítószám, kerület, utca, házszám" value="{{ old('shipping_address') }}" required>
                    @error('shipping_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-chat-left-text text-primary me-1"></i> Megjegyzés</label>
                    <textarea name="note" class="form-control" rows="3" placeholder="Opcionális">{{ old('note') }}</textarea>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="privacy" value="1" id="privacy" required @checked(old('privacy'))>
                    <label class="form-check-label" for="privacy">
                        Elfogadom az <a href="{{ route('privacy') }}" target="_blank">adatkezelési tájékoztatót</a>.
                    </label>
                    @error('privacy')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn-primary-shop w-100">Megrendelés elküldése →</button>
            </form>
            <div class="sidebar-box mt-3">
                <i class="bi bi-truck text-primary me-1"></i>
                Kiszállítás csak Budapesten. A kiszállítás díja {{ number_format($cartData['shipping_fee'], 0, ',', '.') }} Ft. Vidéki kiszállítás jelenleg nem elérhető.
            </div>
        </div>
        <div class="col-lg-5">
            <div class="sidebar-box">
                <h2 class="h5 fw-bold mb-3">Rendelés összesítő</h2>
                @foreach($cartData['items'] as $row)
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ $row['product']->size_label }} × {{ $row['quantity'] }}</span>
                        <strong>{{ number_format($row['line_total'], 0, ',', '.') }} Ft</strong>
                    </div>
                @endforeach
                <hr>
                <div class="d-flex justify-content-between mb-1"><span>Részösszeg</span><span>{{ number_format($cartData['subtotal'], 0, ',', '.') }} Ft</span></div>
                <div class="d-flex justify-content-between mb-1"><span>Szállítás</span><span>{{ number_format($cartData['shipping_fee'], 0, ',', '.') }} Ft</span></div>
                <div class="d-flex justify-content-between fw-bold fs-5 mt-2"><span>Végösszeg</span><span class="text-primary">{{ number_format($cartData['total'], 0, ',', '.') }} Ft</span></div>
            </div>
        </div>
    </div>
</div>
@endsection
