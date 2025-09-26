@extends('layouts.app')

@section('title', $bill->name)

@section('content')
<div class="container-fluid px-4">
    <!-- Bill Header -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div class="d-flex align-items-center">
            <div class="bill-icon bg-primary text-white rounded-circle me-4">
                <i class="bi bi-receipt fs-3"></i>
            </div>
            <div>
                <h1 class="h2 mb-1">{{ $bill->name }}</h1>
                <div class="d-flex align-items-center gap-3">
                    <span class="badge bg-{{ $bill->is_archived ? 'secondary' : 'success' }} fs-6">
                        {{ $bill->is_archived ? 'Archived' : 'Active' }}
                    </span>
                    @if($bill->user_id === auth()->id())
                    <span class="badge bg-primary fs-6">Owner</span>
                    @endif
                    <span class="text-muted">
                        <i class="bi bi-clock me-1"></i>
                        Created {{ $bill->created_at->diffForHumans() }}
                    </span>
                </div>
            </div>
        </div>
        
        @if(!$bill->is_archived)
        <div class="d-flex gap-2">
            @can('update', $bill)
            <a href="{{ route('bills.edit', $bill) }}" class="btn btn-outline-primary">
                <i class="bi bi-pencil me-2"></i>Edit Bill
            </a>
            @endcan
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
                <i class="bi bi-plus-lg me-2"></i>Add Expense
            </button>
        </div>
        @endif
    </div>

    @if(!auth()->check())
    <div class="alert alert-info border-0 shadow-sm mb-5">
        <div class="d-flex align-items-center">
            <i class="bi bi-info-circle fs-4 me-3"></i>
            <div class="flex-grow-1">
                <h5 class="mb-1">You're viewing as a guest</h5>
                <p class="mb-2">Register to become a permanent member and access all features!</p>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-person-plus me-2"></i>Register Now
                </a>
            </div>
        </div>
    </div>
    @endif

    @if($bill->is_archived)
    <div class="alert alert-warning border-0 shadow-sm mb-5">
        <div class="d-flex align-items-center">
            <i class="bi bi-archive fs-4 me-3"></i>
            <div>
                <h5 class="mb-1">This bill is archived</h5>
                <p class="mb-0">You can view but cannot modify it.</p>
            </div>
        </div>
    </div>
    @endif

    <div class="row g-4">
        <!-- Bill Information -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 py-4">
                    <h3 class="h5 mb-0">
                        <i class="bi bi-info-circle text-primary me-2"></i>
                        Bill Information
                    </h3>
                </div>
                <div class="card-body">
                    <!-- Invitation Code -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Invitation Code</label>
                        <div class="input-group">
                            <input type="text" class="form-control" value="{{ $bill->invitation_code }}" readonly>
                            @can('update', $bill)
                            <button class="btn btn-outline-secondary" type="button" onclick="regenerateCode()">
                                <i class="bi bi-arrow-repeat"></i>
                            </button>
                            @endcan
                        </div>
                        <small class="text-muted">Share this code to invite others</small>
                    </div>

                    <!-- Participants -->
                    <div>
                        <label class="form-label fw-semibold">
                            Participants ({{ $bill->participants->count() + 1 }})
                        </label>
                        <div class="participants-list">
                            <div class="participant-item d-flex align-items-center mb-3">
                                <div class="participant-avatar bg-primary text-white rounded-circle me-3">
                                    {{ substr($bill->user->nickname ?? 'U', 0, 1) }}
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold">{{ $bill->user->nickname ?? 'Deleted User' }}</div>
                                    <small class="text-muted">Owner</small>
                                </div>
                            </div>
                            
                            @foreach($bill->participants as $participant)
                            <div class="participant-item d-flex align-items-center mb-3">
                                <div class="participant-avatar bg-secondary text-white rounded-circle me-3">
                                    {{ substr($participant->nickname ?? 'U', 0, 1) }}
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold">{{ $participant->nickname ?? 'Deleted User' }}</div>
                                    <small class="text-muted">Participant</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        @can('update', $bill)
                        <button class="btn btn-outline-primary w-100 mt-3" 
                                data-bs-toggle="modal" data-bs-target="#addParticipantModal">
                            <i class="bi bi-plus me-2"></i>Add Participant
                        </button>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        <!-- Expenses Section -->
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 py-4 d-flex justify-content-between align-items-center">
                    <h3 class="h5 mb-0">
                        <i class="bi bi-currency-dollar text-success me-2"></i>
                        Expenses
                        <span class="badge bg-success ms-2">{{ $bill->expenses->count() }}</span>
                    </h3>
                    
                    @if(!$bill->is_archived)
                    <div class="d-flex gap-2">
                        <div class="input-group" style="width: 200px;">
                            <input type="text" class="form-control" placeholder="Search expenses...">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
                
                <div class="card-body">
                    @if($bill->expenses->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-currency-dollar display-1 text-muted"></i>
                        <h4 class="mt-3 text-muted">No Expenses Yet</h4>
                        <p class="text-muted mb-4">Add your first expense to get started</p>
                        @if(!$bill->is_archived)
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
                            <i class="bi bi-plus-lg me-2"></i>Add Expense
                        </button>
                        @endif
                    </div>
                    @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Expense</th>
                                    <th>Category</th>
                                    <th>Amount</th>
                                    <th>Paid By</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bill->expenses as $expense)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $expense->name }}</div>
                                        <small class="text-muted">{{ Str::limit($expense->description, 50) }}</small>
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill" 
                                              style="background-color: {{ $expense->category->color ?? '#6c757d' }}; color: white;">
                                            {{ $expense->category->name ?? 'Uncategorized' }}
                                        </span>
                                    </td>
                                    <td class="fw-bold text-success">
                                        ${{ number_format($expense->amount, 2) }}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-light rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                {{ substr($expense->payer?->nickname ?? 'U', 0, 1) }}
                                            </div>
                                            {{ $expense->payer?->nickname ?? 'Deleted User' }}
                                        </div>
                                    </td>
                                    <td class="text-muted">
                                        {{ $expense->created_at->format('M d, Y') }}
                                    </td>
                                    <td>
                                        @if(!$bill->is_archived)
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                    type="button" data-bs-toggle="dropdown">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('expenses.edit', $expense) }}">
                                                        <i class="bi bi-pencil me-2"></i>Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('expenses.destroy', $expense) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger" 
                                                                onclick="return confirm('Are you sure you want to delete this expense?')">
                                                            <i class="bi bi-trash me-2"></i>Delete
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                        @else
                                        <span class="text-muted">No actions</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Expense Summary -->
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="card bg-light border-0">
                                <div class="card-body text-center">
                                    <div class="h4 text-primary mb-1">${{ number_format($bill->expenses->sum('amount'), 2) }}</div>
                                    <small class="text-muted">Total Spent</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light border-0">
                                <div class="card-body text-center">
                                    <div class="h4 text-success mb-1">${{ number_format($bill->expenses->avg('amount') ?? 0, 2) }}</div>
                                    <small class="text-muted">Average Expense</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light border-0">
                                <div class="card-body text-center">
                                    <div class="h4 text-info mb-1">{{ $bill->expenses->count() }}</div>
                                    <small class="text-muted">Total Expenses</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Participant Modal -->
<div class="modal fade" id="addParticipantModal" tabindex="-1" aria-labelledby="addParticipantModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addParticipantModalLabel">
                    <i class="bi bi-person-plus me-2"></i>Add Participant
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('bills.participants.store', $bill) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="participant_email" class="form-label">Participant Email</label>
                        <input type="email" class="form-control" id="participant_email" name="email" 
                               placeholder="Enter participant's email" required>
                        <div class="form-text">Enter the email address of the person you want to invite.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Participant</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Expense Modal -->
<div class="modal fade" id="addExpenseModal" tabindex="-1" aria-labelledby="addExpenseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addExpenseModalLabel">
                    <i class="bi bi-plus-lg me-2"></i>Add New Expense
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('expenses.store', $bill) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="expense_name" class="form-label">Expense Name</label>
                                <input type="text" class="form-control" id="expense_name" name="name" 
                                       placeholder="Dinner, Groceries, etc." required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="expense_amount" class="form-label">Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="expense_amount" name="amount" 
                                           step="0.01" min="0" placeholder="0.00" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="expense_description" class="form-label">Description (Optional)</label>
                        <textarea class="form-control" id="expense_description" name="description" 
                                  rows="2" placeholder="Add any details about this expense..."></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="expense_category" class="form-label">Category</label>
                                <select class="form-select" id="expense_category" name="category_id" required>
                                    <option value="">Select a category</option>
                                    @foreach($categories ?? [] as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="expense_payer" class="form-label">Paid By</label>
                                <select class="form-select" id="expense_payer" name="payer_id" required>
                                    <option value="{{ auth()->id() }}">Me ({{ auth()->user()->nickname ?? 'You' }})</option>
                                    @foreach($bill->participants as $participant)
                                        <option value="{{ $participant->id }}">{{ $participant->nickname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Split Type</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="division_type" 
                                       id="split_equal" value="equal" checked>
                                <label class="form-check-label" for="split_equal">Equal Split</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="division_type" 
                                       id="split_custom" value="custom">
                                <label class="form-check-label" for="split_custom">Custom Split</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Expense</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Category Management Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalLabel">
                    <i class="bi bi-tag me-2"></i>Manage Categories
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="new_category_name" class="form-label">Add New Category</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="new_category_name" 
                               placeholder="Enter category name">
                        <button type="button" class="btn btn-primary" onclick="addCategory()">
                            <i class="bi bi-plus"></i>
                        </button>
                    </div>
                </div>
                
                <div class="categories-list">
                    <h6>Existing Categories</h6>
                    <div id="categoriesContainer">
                        @foreach($categories ?? [] as $category)
                            <div class="category-item d-flex justify-content-between align-items-center mb-2">
                                <span class="badge" style="background-color: {{ $category->color ?? '#6c757d' }}; color: white;">
                                    {{ $category->name }}
                                </span>
                                <div>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" 
                                            onclick="editCategory({{ $category->id }})">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            onclick="deleteCategory({{ $category->id }})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
.bill-icon {
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.participant-avatar, .avatar-sm {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}

.avatar-sm {
    width: 30px;
    height: 30px;
    font-size: 0.8rem;
}

.participants-list {
    max-height: 300px;
    overflow-y: auto;
}

.card {
    border-radius: 12px;
}

.btn {
    border-radius: 8px;
}

.table th {
    border-top: none;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.8rem;
    color: #6c757d;
}
</style>

<script>
$(document).ready(function() {
    // Add smooth animations
    $('.card').hover(function() {
        $(this).css('transform', 'translateY(-2px)');
    }, function() {
        $(this).css('transform', 'translateY(0)');
    });
});

function regenerateCode() {
    if (confirm('Are you sure you want to generate a new invitation code? The old code will no longer work.')) {
        fetch('{{ route("bills.generate-code") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.code) {
                document.querySelector('input[name="invitation_code"]').value = data.code;
                alert('New invitation code generated: ' + data.code);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error generating new code');
        });
    }
}

function addCategory() {
    const name = document.getElementById('new_category_name').value;
    if (name.trim() === '') {
        alert('Please enter a category name');
        return;
    }
    
    // Simple client-side addition for demo
    const categoriesContainer = document.getElementById('categoriesContainer');
    const newCategory = document.createElement('div');
    newCategory.className = 'category-item d-flex justify-content-between align-items-center mb-2';
    newCategory.innerHTML = `
        <span class="badge" style="background-color: #6c757d; color: white;">
            ${name}
        </span>
        <div>
            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="editCategoryTemp(this)">
                <i class="bi bi-pencil"></i>
            </button>
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.category-item').remove()">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    `;
    categoriesContainer.appendChild(newCategory);
    document.getElementById('new_category_name').value = '';
}

function editCategory(categoryId) {
    alert('Edit category functionality would go here for ID: ' + categoryId);
}

function deleteCategory(categoryId) {
    if (confirm('Are you sure you want to delete this category?')) {
        alert('Delete category functionality would go here for ID: ' + categoryId);
    }
}

function editCategoryTemp(button) {
    const categoryItem = button.closest('.category-item');
    const badge = categoryItem.querySelector('.badge');
    const currentName = badge.textContent;
    const newName = prompt('Enter new category name:', currentName);
    if (newName && newName.trim() !== '') {
        badge.textContent = newName.trim();
    }
}
</script>
@endsection