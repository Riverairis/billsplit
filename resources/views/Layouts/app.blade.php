<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BillSplit - @yield('title')</title>
    
    <!-- Fonts and Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #4895ef;
            --secondary: #3f37c9;
            --dark: #1a1d29;
            --dark-light: #2d3246;
            --light: #f8f9fa;
            --success: #4cc9f0;
            --gradient-primary: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
            --gradient-dark: linear-gradient(135deg, #1a1d29 0%, #2d3246 100%);
            --shadow-sm: 0 2px 10px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 10px 30px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 20px 50px rgba(0, 0, 0, 0.12);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            color: var(--dark);
            background: linear-gradient(135deg, #f8fafc 0%, #eef2f7 100%);
            min-height: 100vh;
            line-height: 1.6;
        }
        
        .navbar-auth {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            padding: 1rem 0;
            box-shadow: var(--shadow-sm);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .main-content {
            margin-left: 280px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
            background: transparent;
        }
        
        .main-content.collapsed {
            margin-left: 85px;
        }
        
        .container-fluid {
            padding: 2rem;
        }
        
        /* Hide navbar when sidebar is present */
        .has-sidebar .navbar-auth {
            display: none;
        }
        
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary);
        }
        
        /* Loading animation */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Focus states */
        button:focus,
        input:focus,
        select:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }
    </style>
    
    @stack('styles')
</head>
<body class="@if(auth()->check()) has-sidebar @endif">
    <!-- Navigation for auth pages (login/register/welcome) -->
    @unless(auth()->check())
    <nav class="navbar navbar-expand-lg navbar-light navbar-auth fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/" style="color: var(--primary);">
                <i class="bi bi-pie-chart-fill me-2"></i>BillSplit
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('login') }}">Login</a>
                <a class="nav-link" href="{{ route('register') }}">Register</a>
            </div>
        </div>
    </nav>
    @endunless

    @if(auth()->check())
        @include('partials.sidebar')
    @endif

    <main class="@if(auth()->check()) main-content @endif @if(request()->cookie('sidebar_collapsed') === 'true') collapsed @endif">
        @unless(auth()->check())
            <div style="height: 80px;"></div> <!-- Spacer for fixed navbar -->
        @endunless
        
        <div class="container-fluid py-4">
            @yield('content')
        </div>
    </main>

    <!-- Footer for public pages -->
    @unless(auth()->check())
    <footer class="bg-dark text-light py-5 mt-5">
        <div class="container text-center">
            <p>&copy; 2024 BillSplit. All rights reserved.</p>
        </div>
    </footer>
    @endunless

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Add loading states to buttons
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.innerHTML = '<span class="loading-spinner"></span> Processing...';
                        submitBtn.disabled = true;
                    }
                });
            });
            
            // Add smooth animations to cards
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 100);
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>