@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-body text-center py-5">
                <h1 class="mb-4">🍬 Welkom bij Jamin!</h1>
                <p class="lead mb-4">Magazijnbeheer Systeem</p>
                
                <div class="row mt-5">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h5 class="card-title">📦 Leveranciers</h5>
                                <p class="card-text">Bekijk een overzicht van alle leveranciers en hun producten</p>
                                <a href="{{ route('leveranciers.index') }}" class="btn btn-primary">Ga naar overzicht</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
