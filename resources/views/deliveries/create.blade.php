@extends('layouts.app')

@section('title', 'Levering Product')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h2 class="mb-0">Levering Product</h2>
            </div>
            <div class="card-body">
                <p class="text-muted">
                    <strong>Leverancier:</strong> {{ $leverancier->Naam }}<br>
                    <strong>Product:</strong> {{ $product->Naam }} ({{ $product->Barcode }})
                </p>

                <form action="{{ route('deliveries.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="leverancier_id" value="{{ $leverancier->Id }}">
                    <input type="hidden" name="product_id" value="{{ $product->Id }}">

                    <div class="mb-3">
                        <label for="aantal_producteenheden" class="form-label">Aantal Producteenheden</label>
                        <input type="number" class="form-control @error('aantal_producteenheden') is-invalid @enderror" 
                               id="aantal_producteenheden" name="aantal_producteenheden" required min="1">
                        @error('aantal_producteenheden')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="datum_eerstvolgende_levering" class="form-label">Datum Eerstvolgende Levering</label>
                        <input type="date" class="form-control @error('datum_eerstvolgende_levering') is-invalid @enderror" 
                               id="datum_eerstvolgende_levering" name="datum_eerstvolgende_levering" required>
                        @error('datum_eerstvolgende_levering')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('leveranciers.products', $leverancier->Id) }}" class="btn btn-secondary">Annuleer</a>
                        <button type="submit" class="btn btn-primary">💾 Sla op</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
