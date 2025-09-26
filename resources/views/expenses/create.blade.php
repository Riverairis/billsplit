@extends('layouts.app')

@section('title', 'Add Expense')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8 col-md-10">
            <div class="card expense-card">
                <div class="card-header bg-transparent border-0 pt-4">
                    <div class="d-flex align-items-center">
                        <div class="header-icon">
                            <i class="bi bi-plus-circle-fill"></i>
                        </div>
                        <div>
                            <h1 class="card-title mb-1">Add New Expense</h1>
                            <p class="text-muted mb-0">Track your spending efficiently</p>
                        </div>
                    </div>
                </div>

                <div class="card-body px-4 py-3">
                    <form method="POST" action="{{ route('expenses.store') }}" class="expense-form">
                        @csrf
                        
                        <div class="form-section">
                            <label class="form-section-label">Expense Details</label>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select form-select-lg" id="bill_id" name="bill_id" required>
                                            <option value="">Select a bill</option>
                                            @foreach($bills as $bill)
                                                <option value="{{ $bill->id }}">{{ $bill->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="bill_id" class="form-label">
                                            <i class="bi bi-receipt me-2"></i>Bill
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select form-select-lg" id="category_id" name="category_id" required>
                                            <option value="">Select category</option>
                                            @foreach($categories as $category)
                                                @include('partials.category_option', ['category' => $category])
                                            @endforeach
                                        </select>
                                        <label for="category_id" class="form-label">
                                            <i class="bi bi-tag me-2"></i>Category
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control form-control-lg" id="name" name="name" 
                                               placeholder="Expense name" required>
                                        <label for="name" class="form-label">
                                            <i class="bi bi-pencil me-2"></i>Expense Name
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="number" step="0.01" class="form-control form-control-lg" 
                                               id="amount" name="amount" placeholder="0.00" required>
                                        <label for="amount" class="form-label">
                                            <i class="bi bi-currency-dollar me-2"></i>Amount
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-plus-circle me-2"></i>
                                Add Expense
                            </button>
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-lg ms-2">
                                <i class="bi bi-arrow-left me-2"></i>
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .expense-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.95);
        overflow: hidden;
    }
    
    .header-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        color: white;
        font-size: 1.5rem;
    }
    
    .card-title {
        font-weight: 700;
        color: #1a1d29;
        font-size: 1.75rem;
    }
    
    .form-section {
        margin-bottom: 2rem;
    }
    
    .form-section-label {
        font-weight: 600;
        color: #2d3246;
        margin-bottom: 1rem;
        display: block;
        font-size: 1.1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #f0f2f5;
    }
    
    .form-floating {
        position: relative;
    }
    
    .form-control-lg {
        padding: 1rem 1.25rem;
        border-radius: 12px;
        border: 2px solid #eef2f7;
        transition: all 0.3s ease;
        font-size: 1rem;
    }
    
    .form-control-lg:focus {
        border-color: #4361ee;
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        transform: translateY(-2px);
    }
    
    .form-select-lg {
        padding: 1rem 1.25rem;
        border-radius: 12px;
        border: 2px solid #eef2f7;
        transition: all 0.3s ease;
    }
    
    .form-label {
        color: #6c757d;
        font-weight: 500;
    }
    
    .btn-lg {
        padding: 0.875rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
        border: none;
        box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(67, 97, 238, 0.4);
    }
    
    .form-actions {
        padding-top: 1rem;
        border-top: 2px solid #f0f2f5;
    }
</style>
@endsection