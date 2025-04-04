@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4">Dashboard</h1>
            
            @if(auth()->user()->isStandard())
                <div class="alert alert-info">
                    You're using a Standard account. <a href="{{ route('profile.upgrade') }}" class="alert-link">Upgrade to Premium</a> for unlimited bills and participants.
                </div>
            @endif

            <!-- Categories Summary -->
            @if($categories->count() > 0)
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <i class="bi bi-tag"></i> Bill Categories
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($categories as $category)
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <span class="badge" style="background-color: {{ $category->color ?? '#6c757d' }}">&nbsp;&nbsp;</span>
                                                {{ $category->name }}
                                            </h5>
                                            <p class="card-text">
                                                {{ $category->expenses_count }} expenses across bills
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Quick Actions -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <i class="bi bi-plus-circle"></i> Quick Actions
                        </div>
                        <div class="card-body">
                            <button class="btn btn-success mb-2 w-100" data-bs-toggle="modal" data-bs-target="#createBillModal">
                                <i class="bi bi-plus-lg"></i> Create New Bill
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <i class="bi bi-receipt"></i> Your Active Bills
                        </div>
                        <div class="card-body">
                            @if($activeBills->isEmpty() && $sharedBills->isEmpty())
                                <div class="alert alert-info">
                                    You don't have any active bills. Create one to get started!
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Owner</th>
                                                <th>Participants</th>
                                                <th>Expenses</th>
                                                <th>Categories</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($activeBills as $bill)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('bills.show', $bill) }}">{{ $bill->name }}</a>
                                                        @if($bill->user_id === auth()->id())
                                                            <span class="badge bg-primary">Owner</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $bill->user->nickname }}</td>
                                                    <td>{{ $bill->participants->count() }}</td>
                                                    <td>{{ $bill->expenses->count() }}</td>
                                                    <td>
                                                        @foreach($bill->expenses->groupBy('category_id') as $categoryId => $expenses)
                                                            @if($category = $expenses->first()->category)
                                                                <span class="badge" style="background-color: {{ $category->color ?? '#6c757d' }}">
                                                                    {{ $category->name }}
                                                                </span>
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('bills.show', $bill) }}" class="btn btn-info" title="View">
    <i class="bi bi-eye"></i>
</a>
                                                            @if($bill->user_id === auth()->id())
                                                                <a href="{{ route('bills.edit', $bill) }}" class="btn btn-warning" title="Edit">
                                                                    <i class="bi bi-pencil"></i>
                                                                </a>
                                                                <form action="{{ route('bills.archive', $bill) }}" method="POST" style="display: inline;">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-secondary" title="Archive">
                                                                        <i class="bi bi-archive"></i>
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

            @if(!$archivedBills->isEmpty())
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <i class="bi bi-archive"></i> Archived Bills
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Owner</th>
                                        <th>Participants</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($archivedBills as $bill)
                                        <tr>
                                            <td>
                                                <a href="{{ route('bills.show', $bill) }}">{{ $bill->name }}</a>
                                                @if($bill->user_id === auth()->id())
                                                    <span class="badge bg-primary">Owner</span>
                                                @endif
                                            </td>
                                            <td>{{ $bill->user->nickname }}</td>
                                            <td>{{ $bill->participants->count() }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('bills.show', $bill) }}" class="btn btn-info" title="View">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    @if($bill->user_id === auth()->id())
                                                        <form action="{{ route('bills.unarchive', $bill) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success" title="Unarchive">
                                                                <i class="bi bi-arrow-counterclockwise"></i>
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
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Create Bill Modal -->
<div class="modal fade" id="createBillModal" tabindex="-1" aria-labelledby="createBillModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createBillModalLabel">Create New Bill</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('bills.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="billName" class="form-label">Bill Name</label>
                        <input type="text" class="form-control" id="billName" name="name" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Invitation Code</label>
                        <div class="input-group">
                            <input type="text" class="form-control" value="{{ strtoupper(substr(md5(uniqid()), 0, 8)) }}" readonly id="invitationCode" name="invitation_code">
                            <button type="button" class="btn btn-outline-secondary" onclick="generateNewCode()">
                                <i class="bi bi-arrow-repeat"></i> Regenerate
                            </button>
                        </div>
                        <small class="text-muted">Share this code to invite others to your bill</small>
                        @error('invitation_code')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Bill</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function generateNewCode() {
        fetch('{{ route("bills.generate-code") }}')
            .then(response => response.json())
            .then(data => {
                document.getElementById('invitationCode').value = data.code;
            });
    }
</script>
@endsection