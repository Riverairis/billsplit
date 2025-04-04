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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #4895ef;
            --secondary: #3f37c9;
            --dark: #1e1e24;
            --light: #f8f9fa;
            --success: #4cc9f0;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: var(--dark);
            background-color: #f9fafb;
        }
        
        .navbar-auth {
            background-color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        
        .main-content {
            margin-left: 250px;
            transition: all 0.3s ease;
            min-height: 100vh;
        }
        
        .main-content.collapsed {
            margin-left: 70px;
        }
        
        .container-fluid {
            padding: 2rem;
        }
        
        /* Hide navbar when sidebar is present */
        .has-sidebar .navbar-auth {
            display: none;
        }
    </style>
    
    @stack('styles')
</head>
<body class="@if(auth()->check()) has-sidebar @endif">
    <!-- Navigation for auth pages (login/register/welcome) -->
    @unless(auth()->check())
    <nav class="navbar navbar-expand-lg navbar-light navbar-auth">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/" style="color: var(--primary);">
                <i class="bi bi-pie-chart-fill me-2"></i>BillSplit
            </a>
           
        </div>
    </nav>
    @endunless

    @if(auth()->check())
        @include('partials.sidebar')
    @endif

    <main class="@if(auth()->check()) main-content @endif @if(request()->cookie('sidebar_collapsed') === 'true') collapsed @endif">
       
        
        <div class="container-fluid py-4">
            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>