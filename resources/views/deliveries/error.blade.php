@extends('layouts.app')

@section('title', 'Fout bij Levering')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h2 class="mb-0">Levering Product - Fout</h2>
            </div>
            <div class="card-body text-center py-5">
                <div class="alert alert-danger" role="alert">
                    <h5 class="mb-3">⚠️ {{ $message }}</h5>
                    <p class="text-muted">U wordt zo doorgestuurd naar het overzicht...</p>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            window.location.href = "{{ route('leveranciers.products', $leverancier_id) }}";
        }, 4000);
    });
</script>
@endsection
@endsection
