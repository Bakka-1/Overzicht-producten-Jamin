@extends('layouts.app')

@section('title', 'Overzicht Leveranciers')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-white">
                <h2 class="mb-0">Overzicht Leveranciers</h2>
            </div>
            <div class="card-body">
                @if(count($leveranciers) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Leverancier</th>
                                    <th>Contact Persoon</th>
                                    <th>Leverancier Nummer</th>
                                    <th>Mobiel</th>
                                    <th>Aantal Verschillende Producten</th>
                                    <th>Acties</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($leveranciers as $leverancier)
                                    <tr>
                                        <td><strong>{{ $leverancier->Naam }}</strong></td>
                                        <td>{{ $leverancier->ContactPersoon }}</td>
                                        <td>{{ $leverancier->LeverancierNummer }}</td>
                                        <td>{{ $leverancier->Mobiel }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $leverancier->AantalVerschillendeProducten }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('leveranciers.products', $leverancier->Id) }}" 
                                               class="btn btn-sm btn-outline-primary" title="Toon producten">
                                                📦
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        Geen leveranciers gevonden.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
