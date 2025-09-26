@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <!-- Header Section -->
            <div class="profile-header mb-5">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="header-avatar">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <div class="ms-3">
                            <h1 class="page-title mb-1">My Profile</h1>
                            <p class="page-subtitle text-muted">Manage your account settings and preferences</p>
                        </div>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-edit">
                        <i class="bi bi-pencil me-2"></i> Edit Profile
                    </a>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <!-- Account Information Card -->
                <div class="col-lg-8 mb-4">
                    <div class="card profile-card">
                        <div class="card-header card-header-gradient">
                            <div class="d-flex align-items-center">
                                <div class="card-icon">
                                    <i class="bi bi-person-badge"></i>
                                </div>
                                <h5 class="card-title mb-0">Account Information</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="bi bi-person me-2"></i>Full Name
                                        </div>
                                        <div class="info-value">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="bi bi-at me-2"></i>Username
                                        </div>
                                        <div class="info-value">{{ auth()->user()->username }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="bi bi-chat-square-text me-2"></i>Nickname
                                        </div>
                                        <div class="info-value">{{ auth()->user()->nickname ?? 'Not set' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="bi bi-envelope me-2"></i>Email Address
                                        </div>
                                        <div class="info-value">{{ auth()->user()->email }}</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="bi bi-calendar me-2"></i>Member Since
                                        </div>
                                        <div class="info-value">{{ auth()->user()->created_at->format('F j, Y') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Status Card -->
                <div class="col-lg-4 mb-4">
                    <div class="card status-card">
                        <div class="card-header card-header-gradient">
                            <div class="d-flex align-items-center">
                                <div class="card-icon">
                                    <i class="bi bi-award"></i>
                                </div>
                                <h5 class="card-title mb-0">Account Status</h5>
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <div class="status-badge mb-3">
                                @if(auth()->user()->isPremium())
                                    <span class="badge premium-badge">
                                        <i class="bi bi-star-fill me-1"></i> Premium
                                    </span>
                                @elseif(auth()->user()->isStandard())
                                    <span class="badge standard-badge">
                                        <i class="bi bi-person-check me-1"></i> Standard
                                    </span>
                                @else
                                    <span class="badge guest-badge">
                                        <i class="bi bi-person me-1"></i> Guest
                                    </span>
                                @endif
                            </div>
                            
                            <div class="status-content">
                                @if(auth()->user()->isStandard())
                                    <h6 class="status-title">Standard Plan</h6>
                                    <p class="status-text">Upgrade to Premium for unlimited bills and advanced features!</p>
                                    <div class="feature-list">
                                        <div class="feature-item">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                            <span>Basic bill management</span>
                                        </div>
                                        <div class="feature-item">
                                            <i class="bi bi-x-circle text-muted me-2"></i>
                                            <span>Unlimited participants</span>
                                        </div>
                                        <div class="feature-item">
                                            <i class="bi bi-x-circle text-muted me-2"></i>
                                            <span>Advanced analytics</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('profile.upgrade') }}" class="btn btn-warning btn-upgrade mt-3">
                                        <i class="bi bi-rocket me-2"></i> Upgrade to Premium
                                    </a>
                                @elseif(auth()->user()->isPremium())
                                    <h6 class="status-title">Premium Plan</h6>
                                    <p class="status-text">You have full access to all BillSplit features!</p>
                                    <div class="feature-list">
                                        <div class="feature-item">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                            <span>Unlimited bills</span>
                                        </div>
                                        <div class="feature-item">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                            <span>Unlimited participants</span>
                                        </div>
                                        <div class="feature-item">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                            <span>Advanced analytics</span>
                                        </div>
                                    </div>
                                    <div class="premium-badge-expiry mt-3">
                                        <small class="text-muted">Premium member since {{ auth()->user()->updated_at->format('M Y') }}</small>
                                    </div>
                                @else
                                    <h6 class="status-title">Guest Account</h6>
                                    <p class="status-text">Create a full account to access all features!</p>
                                    <div class="feature-list">
                                        <div class="feature-item">
                                            <i class="bi bi-x-circle text-muted me-2"></i>
                                            <span>Limited bill access</span>
                                        </div>
                                        <div class="feature-item">
                                            <i class="bi bi-x-circle text-muted me-2"></i>
                                            <span>Basic functionality</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('register') }}" class="btn btn-primary btn-upgrade mt-3">
                                        <i class="bi bi-person-plus me-2"></i> Create Account
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats Section -->
            <div class="row">
                <div class="col-12">
                    <div class="card stats-card">
                        <div class="card-header card-header-gradient">
                            <div class="d-flex align-items-center">
                                <div class="card-icon">
                                    <i class="bi bi-graph-up"></i>
                                </div>
                                <h5 class="card-title mb-0">Profile Activity</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-3 mb-3">
                                    <div class="stat-item">
                                        <div class="stat-value">12</div>
                                        <div class="stat-label">Active Bills</div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="stat-item">
                                        <div class="stat-value">47</div>
                                        <div class="stat-label">Total Expenses</div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="stat-item">
                                        <div class="stat-value">$1,248</div>
                                        <div class="stat-label">Total Spent</div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="stat-item">
                                        <div class="stat-value">8</div>
                                        <div class="stat-label">Categories</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .profile-header {
        padding: 2rem 0 1rem;
    }

    .header-avatar {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2.5rem;
    }

    .page-title {
        font-weight: 700;
        color: #1a1d29;
        font-size: 2.25rem;
        margin-bottom: 0.25rem;
    }

    .page-subtitle {
        font-size: 1.1rem;
    }

    .btn-edit {
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
        border: none;
        box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
        transition: all 0.3s ease;
    }

    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(67, 97, 238, 0.4);
    }

    .profile-card, .status-card, .stats-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.95);
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .profile-card:hover, .status-card:hover, .stats-card:hover {
        transform: translateY(-5px);
    }

    .card-header-gradient {
        background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
        color: white;
        border: none;
        padding: 1.5rem;
    }

    .card-icon {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.25rem;
    }

    .card-title {
        font-weight: 600;
        font-size: 1.25rem;
        margin-bottom: 0;
    }

    .card-body {
        padding: 2rem;
    }

    .info-item {
        margin-bottom: 1.5rem;
    }

    .info-label {
        font-weight: 600;
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
    }

    .info-value {
        font-size: 1.1rem;
        font-weight: 500;
        color: #1a1d29;
        padding: 0.75rem;
        background: #f8f9fa;
        border-radius: 10px;
        border-left: 4px solid #4361ee;
    }

    .status-badge .badge {
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-size: 1rem;
        font-weight: 600;
    }

    .premium-badge {
        background: linear-gradient(135deg, #ffd700 0%, #ffaa00 100%);
        color: #000;
    }

    .standard-badge {
        background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
        color: white;
    }

    .guest-badge {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        color: white;
    }

    .status-content {
        text-align: center;
    }

    .status-title {
        font-weight: 600;
        color: #1a1d29;
        margin-bottom: 0.5rem;
    }

    .status-text {
        color: #6c757d;
        margin-bottom: 1.5rem;
    }

    .feature-list {
        text-align: left;
        margin-bottom: 1.5rem;
    }

    .feature-item {
        display: flex;
        align-items: center;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
    }

    .btn-upgrade {
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        width: 100%;
        transition: all 0.3s ease;
    }

    .btn-upgrade:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 193, 7, 0.4);
    }

    .stat-item {
        padding: 1.5rem;
    }

    .stat-value {
        font-size: 2.5rem;
        font-weight: 700;
        color: #4361ee;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 0.9rem;
        color: #6c757d;
        font-weight: 500;
    }

    .alert {
        border: none;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .alert-success {
        background: rgba(40, 167, 69, 0.1);
        color: #155724;
        border-left: 4px solid #28a745;
    }

    @media (max-width: 768px) {
        .profile-header {
            text-align: center;
            padding: 1rem 0;
        }
        
        .header-avatar {
            margin: 0 auto 1rem;
        }
        
        .page-title {
            font-size: 1.75rem;
        }
        
        .btn-edit {
            width: 100%;
            margin-top: 1rem;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .stat-value {
            font-size: 2rem;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add animation to stat numbers
        const statValues = document.querySelectorAll('.stat-value');
        statValues.forEach(value => {
            const target = parseInt(value.textContent);
            let current = 0;
            const increment = target / 50;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    value.textContent = target;
                    clearInterval(timer);
                } else {
                    value.textContent = Math.floor(current);
                }
            }, 30);
        });
        
        // Add hover effects to cards
        const cards = document.querySelectorAll('.profile-card, .status-card, .stats-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
</script>
@endsection