@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create New Bill</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('bills.store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Bill Name</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                       name="name" value="{{ old('name') }}" required autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="category" class="col-md-4 col-form-label text-md-right">Category</label>
                            <div class="col-md-6">
                                <input type="text" 
                                       id="category" 
                                       class="form-control @error('category') is-invalid @enderror"
                                       name="category"
                                       value="{{ old('category') }}"
                                       required
                                       list="categoryOptions"
                                       placeholder="Type or select a category">
                                <datalist id="categoryOptions">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->name }}">
                                    @endforeach
                                </datalist>
                                @error('category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Invitation Code</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" class="form-control" 
                                           name="invitation_code" 
                                           value="{{ $invitation_code }}" 
                                           readonly required>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary" 
                                                onclick="regenerateCode()">
                                            Regenerate
                                        </button>
                                    </div>
                                </div>
                                @error('invitation_code')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Create Bill
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function regenerateCode() {
        fetch('{{ route("bills.generate-code") }}')
            .then(response => response.json())
            .then(data => {
                document.querySelector('input[name="invitation_code"]').value = data.code;
            });
    }
</script>
@endsection