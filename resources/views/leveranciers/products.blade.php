@extends('layouts.app')

@section('title', 'Geleverde Producten')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-0">Geleverde Producten</h2>
                        <p class="text-muted mb-0">Leverancier: <strong>{{ $leverancier->Naam }}</strong></p>
                    </div>
                    <a href="{{ route('leveranciers.index') }}" class="btn btn-secondary">← Terug</a>
                </div>
            </div>
            <div class="card-body">
                @if(count($products) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Product Naam</th>
                                    <th>Barcode</th>
                                    <th>Aantal in Magazijn</th>
                                    <th>Laatste Levering</th>
                                    <th>Acties</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td><strong>{{ $product->Naam }}</strong></td>
                                        <td><code>{{ $product->Barcode }}</code></td>
                                        <td>
                                            <span class="badge bg-success">{{ $product->AantalAanwezig ?? 0 }}</span>
                                        </td>
                                        <td>{{ $product->LaatsteAanlevering ? \Carbon\Carbon::parse($product->LaatsteAanlevering)->format('d-m-Y') : 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('deliveries.create', ['leverancier_id' => $leverancier->Id, 'product_id' => $product->ProductId]) }}" 
                                               class="btn btn-sm btn-outline-success" title="Nieuwe levering">
                                                ➕
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        Dit bedrijf heeft tot nu toe geen producten geleverd aan Jamin
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
