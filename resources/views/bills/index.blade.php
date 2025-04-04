@extends('layouts.app')

@section('title', 'My Bills')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>My Bills</h1>
                <a href="{{ route('bills.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-lg"></i> Create New Bill
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-receipt"></i> Bill List
                </div>
                <div class="card-body">
                    @if($bills->isEmpty())
                        <div class="alert alert-info">
                            You don't have any bills yet. Create one to get started!
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Invitation Code</th>
                                        <th>Participants</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bills as $bill)
                                        <tr>
                                            <td>
                                                <a href="{{ route('bills.show', $bill) }}">{{ $bill->name }}</a>
                                            </td>
                                            <td>{{ $bill->invitation_code }}</td>
                                            <td>{{ $bill->participants->count() }}</td>
                                            <td>
                                                @if($bill->is_archived)
                                                    <span class="badge bg-secondary">Archived</span>
                                                @else
                                                    <span class="badge bg-success">Active</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('bills.show', $bill) }}" class="btn btn-info" title="View">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('bills.edit', $bill) }}" class="btn btn-warning" title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    @if($bill->is_archived)
                                                        <form action="{{ route('bills.unarchive', $bill) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success" title="Unarchive">
                                                                <i class="bi bi-arrow-counterclockwise"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('bills.archive', $bill) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-secondary" title="Archive">
                                                                <i class="bi bi-archive"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <form action="{{ route('bills.destroy', $bill) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this bill?')">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
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
@endsection