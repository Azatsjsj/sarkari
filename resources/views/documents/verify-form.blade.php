{{-- resources/views/documents/verify-form.blade.php --}}
@extends('layouts.app')

@section('title', 'Certificate Verification - Sarkari Result')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h3><i class="fas fa-shield-alt"></i> Certificate Verification</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('documents.verify') }}" method="POST">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="certificate_number">Enter Certificate Number:</label>
                            <input type="text" name="certificate_number" id="certificate_number" 
                                   class="form-control form-control-lg" 
                                   placeholder="e.g., UPSSSC/2023/12345" required>
                            <small class="text-muted">Enter the certificate number mentioned on your document</small>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-search"></i> Verify Certificate
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <a href="{{ route('documents.index') }}" class="btn btn-link">
                    <i class="fas fa-arrow-left"></i> Back to Documents
                </a>
            </div>
        </div>
    </div>
</div>
@endsection