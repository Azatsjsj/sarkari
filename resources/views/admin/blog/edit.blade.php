@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Article</h1>
    <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
</div>

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
</div>
@endif

<form action="{{ route('admin.blog.update', $blog) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('admin.blog._form', ['blog' => $blog])
    <button type="submit" class="btn btn-primary">Update Article</button>
</form>
@endsection
