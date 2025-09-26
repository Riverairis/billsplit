@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid px-4">
    <!-- Welcome Header -->
    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h1 class="h2 mb-1">Welcome back, {{ auth()->user()->first_name }}! 👋</h1>
            <p class="text-muted">Here's what's happening with your bills today</p>
        </div>
        <div class="d-flex gap-3">
            <div class="text-end">
                <div class="h4 mb-0">{{ $activeBills->count() + $sharedBills->count() }}</div>
                <small class="text-muted">Active Bills</small>
            </div>
            <div class="text-end">
                <div class="h4 mb-0">{{ $categories->sum('expenses_count') }}</div>
                <small class="text-muted">Total Expenses</small>
            </div>
        </div>
    </div>

    @if(auth()->user()->isStandard())
    <div class="alert alert-warning alert-dismissible fade show mb-5" role="alert">
        <div class="d-flex align-items-center">
            <i class="bi bi-star-fill me-3 fs-5"></i>
            <div class="flex-grow-1">
                <strong>Upgrade to Premium!</strong> Get unlimited bills and participants with advanced features.
            </div>
            <a href="{{ route('profile.upgrade') }}" class="btn btn-warning btn-sm">Upgrade Now</a>
        </div>
    </div>
    @endif

    <div class="row g-4">
        <!-- Categories Summary -->
        @if($categories->count() > 0)
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 py-4">
                    <h3 class="h5 mb-0">
                        <i class="bi bi-tag-fill text-primary me-2"></i>
                        Bill Categories
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach($categories as $category)
                        <div class="col-xl-3 col-md-4 col-sm-6">
                            <div class="card border-0 bg-light-hover transition-all">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="category-badge" style="background-color: {{ $category->color ?? '#6c757d' }}"></div>
                                        <h6 class="mb-0 ms-3">{{ $category->name }}</h6>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted small">Expenses</span>
                                        <span class="badge bg-primary rounded-pill">{{ $category->expenses_count }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Quick Actions & Active Bills -->
        <div class="col-xl-4">
            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0 py-4">
                    <h3 class="h5 mb-0">
                        <i class="bi bi-lightning-fill text-warning me-2"></i>
                        Quick Actions
                    </h3>
                </div>
                <div class="card-body">
                    <button class="btn btn-primary w-100 py-3 mb-3 d-flex align-items-center justify-content-center" 
                            data-bs-toggle="modal" data-bs-target="#createBillModal">
                        <i class="bi bi-plus-lg me-2"></i>
                        Create New Bill
                    </button>
                    
                    <div class="list-group list-group-flush">
                        <a href="{{ route('bills.index') }}" class="list-group-item list-group-item-action border-0 px-0 py-3">
                            <i class="bi bi-receipt text-primary me-3"></i>
                            View All Bills
                        </a>
                        <a href="{{ route('profile.show') }}" class="list-group-item list-group-item-action border-0 px-0 py-3">
                            <i class="bi bi-person text-success me-3"></i>
                            My Profile
                        </a>
                    </div>
                </div>
            </div>

            
        </div>

        <!-- Active Bills -->
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 py-4 d-flex justify-content-between align-items-center">
                    <h3 class="h5 mb-0">
                        <i class="bi bi-receipt text-success me-2"></i>
                        Your Active Bills
                    </h3>
                    <span class="badge bg-success">{{ $activeBills->count() + $sharedBills->count() }}</span>
                </div>
                <div class="card-body">
                    @if($activeBills->isEmpty() && $sharedBills->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-receipt display-1 text-muted"></i>
                        <h4 class="mt-3 text-muted">No Active Bills</h4>
                        <p class="text-muted mb-4">Create your first bill to get started</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createBillModal">
                            Create Bill
                        </button>
                    </div>
                    @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Bill Name</th>
                                    <th>Participants</th>
                                    <th>Expenses</th>
                                    <th>Last Activity</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activeBills as $bill)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bill-avatar bg-primary text-white rounded-circle me-3">
                                                {{ substr($bill->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <a href="{{ route('bills.show', $bill) }}" class="text-decoration-none fw-semibold">
                                                    {{ $bill->name }}
                                                </a>
                                                <div class="small text-muted">
                                                    {{ $bill->user->nickname }}
                                                    @if($bill->user_id === auth()->id())
                                                    <span class="badge bg-primary ms-1">Owner</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ $bill->participants->count() }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ $bill->expenses->count() }}</span>
                                    </td>
                                    <td class="text-muted small">
                                        {{ $bill->updated_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        <span class="badge bg-success">Active</span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                    type="button" data-bs-toggle="dropdown">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('bills.show', $bill) }}">
                                                        <i class="bi bi-eye me-2"></i>View
                                                    </a>
                                                </li>
                                                @if($bill->user_id === auth()->id())
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('bills.edit', $bill) }}">
                                                        <i class="bi bi-pencil me-2"></i>Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('bills.archive', $bill) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="bi bi-archive me-2"></i>Archive
                                                        </button>
                                                    </form>
                                                </li>
                                                @endif
                                            </ul>
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

            <!-- Archived Bills -->
            @if(!$archivedBills->isEmpty())
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-transparent border-0 py-4">
                    <h3 class="h5 mb-0 text-muted">
                        <i class="bi bi-archive me-2"></i>
                        Archived Bills
                    </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm align-middle">
                            <tbody>
                                @foreach($archivedBills as $bill)
                                <tr class="text-muted">
                                    <td class="w-50">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-archive me-3"></i>
                                            {{ $bill->name }}
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('bills.show', $bill) }}" class="btn btn-outline-secondary">
                                                View
                                            </a>
                                            @if($bill->user_id === auth()->id())
                                            <form action="{{ route('bills.unarchive', $bill) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-success">
                                                    Restore
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
<div class="modal fade" id="createBillModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bi bi-plus-circle me-2"></i>
                    Create New Bill
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('bills.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Bill Name</label>
                        <input type="text" class="form-control form-control-lg" name="name" 
                               placeholder="Enter bill name" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Invitation Code</label>
                        <div class="input-group input-group-lg">
                            <input type="text" class="form-control" value="{{ strtoupper(substr(md5(uniqid()), 0, 8)) }}" 
                                   readonly id="invitationCode" name="invitation_code">
                            <button type="button" class="btn btn-outline-secondary" onclick="generateNewCode()">
                                <i class="bi bi-arrow-repeat"></i>
                            </button>
                        </div>
                        <small class="text-muted">Share this code to invite others to your bill</small>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-plus-lg me-2"></i>Create Bill
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.bill-avatar {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}

.category-badge {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    flex-shrink: 0;
}

.bg-light-hover:hover {
    background-color: #f8f9fa !important;
    transform: translateY(-2px);
}

.transition-all {
    transition: all 0.3s ease;
}

.activity-badge {
    width: 8px;
    height: 8px;
    margin-top: 6px;
}

.activity-item:last-child {
    margin-bottom: 0 !important;
}
</style>

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