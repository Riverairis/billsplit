@extends('layouts.app')

@section('title', 'Add Expense')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add New Expense</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('expenses.store') }}">
                        @csrf
                        
                        <!-- Add your form fields here -->
                        <div class="mb-3">
                            <label for="bill_id" class="form-label">Bill</label>
                            <select class="form-select" id="bill_id" name="bill_id" required>
                                @foreach($bills as $bill)
                                    <option value="{{ $bill->id }}">{{ $bill->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Expense Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Add Expense</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection