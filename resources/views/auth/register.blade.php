@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-lg" style="border-radius: 16px;">
                <div class="card-header bg-white border-0 text-center py-4">
                    <h2 class="fw-bold" style="color: var(--primary);">
                        <i class="bi bi-person-plus-fill me-2"></i>Create Account
                    </h2>
                    <p class="text-muted mb-0">Join BillSplit to simplify your shared expenses</p>
                </div>

                <div class="card-body px-5 py-4">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label">{{ __('First Name') }}</label>
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                       name="first_name" value="{{ old('first_name') }}" required autocomplete="given-name"
                                       style="padding: 12px; border-radius: 8px; border: 1px solid #e0e0e0;">
                                @error('first_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="last_name" class="form-label">{{ __('Last Name') }}</label>
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                       name="last_name" value="{{ old('last_name') }}" required autocomplete="family-name"
                                       style="padding: 12px; border-radius: 8px; border: 1px solid #e0e0e0;">
                                @error('last_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="nickname" class="form-label">{{ __('Nickname') }}</label>
                            <input id="nickname" type="text" class="form-control @error('nickname') is-invalid @enderror" 
                                   name="nickname" value="{{ old('nickname') }}" required autocomplete="nickname"
                                   style="padding: 12px; border-radius: 8px; border: 1px solid #e0e0e0;">
                            @error('nickname')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email"
                                   style="padding: 12px; border-radius: 8px; border: 1px solid #e0e0e0;">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="username" class="form-label">{{ __('Username') }}</label>
                            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" 
                                   name="username" value="{{ old('username') }}" required autocomplete="username"
                                   style="padding: 12px; border-radius: 8px; border: 1px solid #e0e0e0;">
                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="new-password"
                                   style="padding: 12px; border-radius: 8px; border: 1px solid #e0e0e0;">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <small class="form-text text-muted">
                                Password must be 8-16 characters long with at least one uppercase, one lowercase, one number, and one special character.
                            </small>
                        </div>

                        <div class="mb-4">
                            <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control" 
                                   name="password_confirmation" required autocomplete="new-password"
                                   style="padding: 12px; border-radius: 8px; border: 1px solid #e0e0e0;">
                        </div>

                        @if(request()->has('invite'))
    <div class="alert alert-info">
        You've been invited to join a bill! Complete registration to access it.
    </div>
    <input type="hidden" name="invitation_token" value="{{ request()->invite }}">
@endif

                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary btn-lg" style="border-radius: 8px; padding: 12px;">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-footer bg-white border-0 text-center py-4">
                    <p class="mb-0">Already have an account? <a href="{{ route('login') }}" style="color: var(--primary); font-weight: 500;">Sign in</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection