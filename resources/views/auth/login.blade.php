@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
                <div class="card-header bg-white text-center py-4 position-relative">
                    <div class="mb-3">
                        <i class="bi bi-box-arrow-in-right" style="font-size: 2.5rem; color: var(--primary);"></i>
                    </div>
                    <h2 class="fw-bold mb-2" style="color: var(--primary);">Welcome Back</h2>
                    <p class="text-muted mb-0">Sign in to manage your shared expenses</p>
                </div>

                <div class="card-body px-5 py-4">
                    <!-- Session Status and Alerts -->
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('verified'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ __('Your email has been verified! You can now log in.') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('verification_required'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            {{ __('Please verify your email address by clicking the link sent to your Gmail before logging in.') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                        @csrf
                        <input type="hidden" name="invitation_code" value="{{ request('code') }}">

                        <!-- Username Field -->
                        <div class="mb-4">
                            <label for="username" class="form-label fw-semibold text-muted">Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-person-fill" style="font-size: 1.2rem; color: var(--primary);"></i>
                                </span>
                                <input id="username" type="text" 
                                       class="form-control border-start-0 @error('username') is-invalid @enderror" 
                                       name="username" value="{{ old('username') }}" required 
                                       autocomplete="username" autofocus 
                                       placeholder="Enter your username">
                                @error('username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold text-muted">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-lock-fill" style="font-size: 1.2rem; color: var(--primary);"></i>
                                </span>
                                <input id="password" type="password" 
                                       class="form-control border-start-0 @error('password') is-invalid @enderror" 
                                       name="password" required autocomplete="current-password" 
                                       placeholder="Enter your password">
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Invitation Code Field with View Bill Button -->
                        <div class="mb-4">
                            <label for="invitation_code" class="form-label fw-semibold text-muted">Invitation Code <span class="text-muted fw-normal">(Optional)</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-ticket-perforated" style="font-size: 1.2rem; color: var(--primary);"></i>
                                </span>
                                <input id="invitation_code" type="text" 
                                       class="form-control border-start-0" 
                                       name="invitation_code_display" 
                                       value="{{ request('code') ?? old('invitation_code') }}" 
                                       placeholder="Enter code to view bill as guest">
                                <button type="button" id="guestViewBtn" class="btn btn-outline-primary ms-2">
                                    <i class="bi bi-eye-fill me-1"></i> View
                                </button>
                            </div>
                            <small class="form-text text-muted mt-1">
                                Have an invitation code? Enter it and click "View" to see the bill.
                            </small>
                        </div>

                        <!-- Remember Me and Forgot Password -->
                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" 
                                       id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label text-muted" for="remember">
                                    Remember Me
                                </label>
                            </div>
                            @if (Route::has('password.request'))
                                <a class="text-decoration-none fw-medium" href="{{ route('password.request') }}" style="color: var(--primary);">
                                    Forgot Password?
                                </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary py-2 fw-semibold shadow-sm">
                                <i class="bi bi-arrow-right-circle me-2"></i> Login
                            </button>
                        </div>

                        <!-- Sign Up Link -->
                        <div class="text-center pt-3">
                            <p class="text-muted mb-0">Don't have an account? 
                                <a href="{{ route('register') }}" class="text-decoration-none fw-semibold" style="color: var(--primary);">
                                    Sign Up
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control, .input-group-text, .btn {
        height: 50px;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    .input-group .btn {
        height: 50px;
        padding: 0 20px;
        line-height: 48px;
    }
    .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(var(--primary-rgb), 0.2);
        border-color: var(--primary);
    }
    .input-group-text {
        background-color: #f8f9fa;
    }
    .btn-primary {
        border-radius: 10px;
        background: var(--primary);
        border: none;
    }
    .btn-primary:hover {
        background: var(--secondary);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(var(--primary-rgb), 0.3);
    }
    .btn-outline-primary {
        border-radius: 10px;
    }
    .btn-outline-primary:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(var(--primary-rgb), 0.2);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const guestViewBtn = document.getElementById('guestViewBtn');
    const invitationCodeInput = document.getElementById('invitation_code');
    
    guestViewBtn.addEventListener('click', function() {
        const code = invitationCodeInput.value.trim();
        
        if (!code) {
            showError('Please enter an invitation code');
            return;
        }

        fetch("{{ route('guest.join') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ code: code })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                throw new Error('No redirect URL provided');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError(error.message || error.error || 'An error occurred');
        });
    });

    function showError(message) {
        // Remove any existing error
        const existingError = invitationCodeInput.nextElementSibling;
        if (existingError && existingError.classList.contains('invalid-feedback')) {
            existingError.remove();
        }
        
        // Add new error
        invitationCodeInput.classList.add('is-invalid');
        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback d-block';
        errorDiv.textContent = message;
        invitationCodeInput.parentNode.insertBefore(errorDiv, invitationCodeInput.nextSibling);
    }
});
</script>
@endsection