@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>My Profile</h1>
                <a href="{{ route('profile.edit') }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit Profile
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-person"></i> Account Information
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h5 class="card-title">Name</h5>
                                <p class="card-text">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</p>
                            </div>
                            <div class="mb-3">
                                <h5 class="card-title">Nickname</h5>
                                <p class="card-text">{{ auth()->user()->nickname }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h5 class="card-title">Email</h5>
                                <p class="card-text">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="mb-3">
                                <h5 class="card-title">Username</h5>
                                <p class="card-text">{{ auth()->user()->username }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-award"></i> Account Type
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">
                                @if(auth()->user()->isPremium())
                                    <span class="badge bg-warning text-dark">Premium Account</span>
                                @elseif(auth()->user()->isStandard())
                                    <span class="badge bg-primary">Standard Account</span>
                                @else
                                    <span class="badge bg-info">Guest Account</span>
                                @endif
                            </h5>
                            @if(auth()->user()->isStandard())
                                <p class="card-text">Upgrade to Premium for unlimited bills and participants!</p>
                            @elseif(auth()->user()->isPremium())
                                <p class="card-text">You have full access to all features.</p>
                            @else
                                <p class="card-text">Guest accounts have limited access.</p>
                            @endif
                        </div>
                        @if(auth()->user()->isStandard())
                            <a href="{{ route('profile.upgrade') }}" class="btn btn-warning">
                                <i class="bi bi-star-fill"></i> Upgrade to Premium
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection