<!-- resources/views/results/category.blade.php -->
@extends('layouts.app')

@section('title', $category->name . ' Results - Sarkari Result')
@section('content')
<div class="container mt-4">
    <!-- Category Header -->
    <div class="card bg-primary text-white mb-4">
        <div class="card-body">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-dark">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('results') }}" class="text-white">Results</a></li>
                    <li class="breadcrumb-item active text-white">{{ $category->name }}</li>
                </ol>
            </nav>
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-6 mb-2">
                        <i class="fas fa-chart-bar"></i> {{ $category->name }} Results
                    </h1>
                    <p class="lead mb-0">
                        Browse all results in {{ $category->name }} category
                        <span class="badge bg-warning text-dark ms-2">{{ $results->total() }} Results</span>
                    </p>
                </div>
                <div class="col-md-4 text-center">
                    <i class="fas fa-award fa-5x text-white-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Rest of the results index content -->
    @include('results.partials.index-content')
</div>
@endsection