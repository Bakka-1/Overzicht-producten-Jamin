@extends('layouts.app')

@section('title', 'Geen Producten')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-white">
                <h2 class="mb-0">Geleverde Producten</h2>
            </div>
            <div class="card-body text-center py-5">
                <div class="alert alert-info" role="alert">
                    <h5 class="mb-3">Dit bedrijf heeft tot nu toe geen producten geleverd aan Jamin</h5>
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
            window.location.href = "{{ route('leveranciers.index') }}";
        }, 3000);
    });
</script>
@endsection
@endsection
