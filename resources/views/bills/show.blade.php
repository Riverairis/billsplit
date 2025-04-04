@extends('layouts.app')

@section('title', $bill->name)

@section('content')

@if(!auth()->check())
<div class="alert alert-info">
    <h5>You're viewing as a guest</h5>
    <p>Want to become a permanent member?</p>
    <a href="{{ route('register') }}" class="btn btn-primary">
        Register Now
    </a>
</div>
@endif
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $bill->name }}</h5>
                    <div>
                        <span class="badge bg-{{ $bill->is_archived ? 'secondary' : 'success' }}">
                            {{ $bill->is_archived ? 'Archived' : 'Active' }}
                        </span>
                        @if($bill->user_id === auth()->id())
                            <span class="badge bg-primary">Owner</span>
                        @endif
                    </div>
                </div>

                <div class="card-body">
                    @if($bill->is_archived)
                        <div class="alert alert-info">
                            This bill is archived. You can view but cannot modify it.
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Invitation Code</h6>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" value="{{ $bill->invitation_code }}" readonly>
                                @can('update', $bill)
                                    <button class="btn btn-outline-secondary" type="button" onclick="regenerateCode()">
                                        <i class="bi bi-arrow-repeat"></i> Regenerate
                                    </button>
                                @endcan
                            </div>
                            <small class="text-muted">Share this code to invite others</small>
                        </div>

                        <div class="col-md-6">
                            <h6>Participants ({{ $bill->participants->count() + 1 }})</h6>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-primary">{{ $bill->user->nickname ?? 'Deleted User' }} (Owner)</span>
                                @foreach($bill->participants as $participant)
                                    <span class="badge bg-secondary">{{ $participant->nickname ?? 'Deleted User' }}</span>
                                @endforeach
                            </div>
                            @can('update', $bill)
                                <button class="btn btn-sm btn-outline-primary mt-2" data-bs-toggle="modal" data-bs-target="#addParticipantModal">
                                    <i class="bi bi-plus"></i> Add Participant
                                </button>
                            @endcan
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5>Expenses</h5>
                        @if(!$bill->is_archived)
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
                                <i class="bi bi-plus"></i> Add Expense
                            </button>
                        @endif
                    </div>

                    @if($bill->expenses->isEmpty())
                        <div class="alert alert-info">
                            No expenses added yet. Add your first expense to get started!
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
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
                                            <td>{{ $expense->name }}</td>
                                            <td>
                                                <span class="badge" style="background-color: {{ $expense->category->color ?? '#6c757d' }}">
                                                    {{ $expense->category->name ?? 'Uncategorized' }}
                                                </span>
                                            </td>
                                            <td>${{ number_format($expense->amount, 2) }}</td>
                                            <td>{{ $expense->payer?->nickname ?? 'Deleted User' }}</td>
                                            <td>{{ $expense->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    @if(!$bill->is_archived)
                                                        <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-warning" title="Edit">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <form action="{{ route('expenses.destroy', $expense) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this expense?')">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                <h5 class="modal-title" id="addParticipantModalLabel">Add Participant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('bills.addParticipant', $bill) }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="user_type" class="form-label">User Type</label>
                        <select class="form-select" id="user_type" name="user_type" required>
                            <option value="registered">Registered User</option>
                            <option value="guest">Guest User</option>
                        </select>
                    </div>
                    <div id="guestFields" style="display: none;">
                        <div class="mb-3">
                            <label for="nickname" class="form-label">Nickname</label>
                            <input type="text" class="form-control" id="nickname" name="nickname">
                        </div>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addExpenseModalLabel">Add Expense</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('expenses.store') }}">
                @csrf
                <input type="hidden" name="bill_id" value="{{ $bill->id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Expense Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="category_input" class="form-label">Category</label>
                        <div class="input-group">
                            <input type="text" 
                                   id="category_input" 
                                   class="form-control @error('category') is-invalid @enderror"
                                   list="category_options"
                                   name="category"
                                   value="{{ old('category') }}"
                                   autocomplete="off"
                                   placeholder="Type a new category or select from list"
                                   required>
                            <datalist id="category_options">
                                @foreach($categories as $category)
                                    <option value="{{ $category->name }}" data-id="{{ $category->id }}" data-color="{{ $category->color }}">
                                @endforeach
                            </datalist>
                            <input type="hidden" name="category_id" id="category_id" value="{{ old('category_id') }}">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#categoryModal">
                                    <i class="fas fa-plus"></i> New
                                </button>
                            </div>
                        </div>
                        @error('category')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="paid_by" class="form-label">Paid By</label>
                        <select class="form-select" id="paid_by" name="paid_by" required>
                            <option value="{{ auth()->id() }}">{{ auth()->user()->nickname }} (Me)</option>
                            @foreach($bill->participants as $participant)
                                @if($participant)
                                    <option value="{{ $participant->id }}">{{ $participant->nickname }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="split_type" class="form-label">Split Type</label>
                        <select class="form-select" id="split_type" name="split_type" required>
                            <option value="equal">Equally divided</option>
                            <option value="custom">Custom</option>
                        </select>
                    </div>
                    <div id="customSplitSection" style="display: none;">
                        <label class="form-label">Custom Split</label>
                        @foreach($bill->participants as $participant)
                            @if($participant)
                                <div class="input-group mb-2">
                                    <span class="input-group-text">{{ $participant->nickname }}</span>
                                    <input type="number" step="0.01" class="form-control" name="split[{{ $participant->id }}]" placeholder="Amount">
                                </div>
                            @endif
                        @endforeach
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

<!-- Category Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Category</h5>
                <button type="button" class="close" data-bs-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="newCategoryForm" action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="color" class="form-label">Color (optional)</label>
                        <input type="color" class="form-control" id="color" name="color" value="#6c757d">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Handle category selection or free input
    $('#category_input').on('input', function() {
        const input = $(this).val();
        const option = $(`#category_options option[value="${input}"]`);
        $('#category_id').val(option.length > 0 ? option.data('id') : '');
    });

    // Handle new category form submission via AJAX
    $('#newCategoryForm').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '{{ route('categories.store') }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    const newOption = `<option value="${response.category.name}" data-id="${response.category.id}" data-color="${response.category.color}">`;
                    $('#category_options').append(newOption);
                    $('#category_input').val(response.category.name);
                    $('#category_id').val(response.category.id);
                    $('#categoryModal').modal('hide');
                    $('#newCategoryForm')[0].reset();
                }
            },
            error: function(xhr) {
                alert(xhr.responseJSON.message || 'Error creating category');
            }
        });
    });

    // Toggle guest fields based on user type
    $('#user_type').change(function() {
        if ($(this).val() === 'guest') {
            $('#guestFields').show();
            $('#nickname').prop('required', true);
        } else {
            $('#guestFields').hide();
            $('#nickname').prop('required', false);
        }
    });

    // Toggle custom split section
    $('#split_type').change(function() {
        $('#customSplitSection').toggle(this.value === 'custom');
    });
});

function regenerateCode() {
    fetch('{{ route("bills.regenerate", $bill) }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.code) {
            document.querySelector('input[value="{{ $bill->invitation_code }}"]').value = data.code;
            location.reload();
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
@endsection