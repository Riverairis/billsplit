@extends('layouts.app')

@section('title', 'Join a Bill')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-lg" style="border-radius: 16px;">
                <div class="card-header bg-white border-0 text-center py-4">
                    <h2 class="fw-bold" style="color: var(--primary);">
                        <i class="bi bi-people-fill me-2"></i>Join a Bill
                    </h2>
                    <p class="text-muted mb-0">Enter your invitation code to join a shared bill</p>
                </div>

                <div class="card-body px-5 py-4">
                    <form method="POST" action="{{ route('guest.join') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="code" class="form-label">Invitation Code</label>
                            <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" 
                                   name="code" value="{{ old('code') }}" required
                                   style="padding: 12px; border-radius: 8px; border: 1px solid #e0e0e0;">
                            @error('code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div id="guestFields" style="display: none;">
                            <h5 class="mt-4 mb-3">Guest Information</h5>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}"
                                       style="padding: 12px; border-radius: 8px; border: 1px solid #e0e0e0;">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                           name="first_name" value="{{ old('first_name') }}"
                                           style="padding: 12px; border-radius: 8px; border: 1px solid #e0e0e0;">
                                    @error('first_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                           name="last_name" value="{{ old('last_name') }}"
                                           style="padding: 12px; border-radius: 8px; border: 1px solid #e0e0e0;">
                                    @error('last_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="nickname" class="form-label">Nickname</label>
                                <input id="nickname" type="text" class="form-control @error('nickname') is-invalid @enderror" 
                                       name="nickname" value="{{ old('nickname') }}"
                                       style="padding: 12px; border-radius: 8px; border: 1px solid #e0e0e0;">
                                @error('nickname')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="button" id="toggleGuestBtn" class="btn btn-outline-primary me-md-2">
                                Join as Guest
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Join Bill
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleGuestBtn = document.getElementById('toggleGuestBtn');
        const guestFields = document.getElementById('guestFields');
        
        toggleGuestBtn.addEventListener('click', function() {
            if (guestFields.style.display === 'none') {
                guestFields.style.display = 'block';
                toggleGuestBtn.textContent = 'Join as Registered User';
                // Add hidden field to indicate guest mode
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'is_guest';
                input.value = '1';
                document.querySelector('form').appendChild(input);
            } else {
                guestFields.style.display = 'none';
                toggleGuestBtn.textContent = 'Join as Guest';
                // Remove hidden field
                const hiddenInput = document.querySelector('input[name="is_guest"]');
                if (hiddenInput) {
                    hiddenInput.remove();
                }
            }
        });
    });
</script>
@endsection