<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BillSplit - Smart Expense Sharing</title>
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
            overflow-x: hidden;
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        }
        
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary);
            border-color: var(--secondary);
        }
        
        .btn-outline-light:hover {
            color: var(--primary);
        }
        
        .feature-icon {
            width: 60px;
            height: 60px;
            background-color: rgba(67, 97, 238, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            color: var(--primary);
            font-size: 1.5rem;
        }
        
        .nav-pills .nav-link.active {
            background-color: var(--dark);
        }
        
        .testimonial-card {
            border-radius: 16px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }
        
        .testimonial-card:hover {
            transform: translateY(-5px);
        }
        
        .stats-card {
            border-radius: 16px;
            background-color: white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            text-align: center;
        }
        
        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }
        
        .stats-label {
            font-size: 0.9rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .wave-divider {
            position: relative;
            height: 100px;
            overflow: hidden;
        }
        
        .wave-divider svg {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        
        .pricing-card {
            border-radius: 16px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .pricing-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        }
        
        .pricing-card .card-header {
            background-color: var(--primary);
            color: white;
            padding: 1.5rem;
            text-align: center;
        }
        
        .pricing-card .price {
            font-size: 2.5rem;
            font-weight: 700;
        }
        
        .pricing-card.featured {
            border: 2px solid var(--primary);
            position: relative;
        }
        
        .pricing-card.featured .featured-badge {
            position: absolute;
            top: -10px;
            right: 20px;
            background-color: var(--success);
            color: white;
            padding: 0.25rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .footer {
            background-color: var(--dark);
            color: white;
            padding: 4rem 0 2rem;
        }
        
        .footer a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer a:hover {
            color: white;
        }
        
        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .social-icon:hover {
            background-color: var(--primary);
            transform: translateY(-3px);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
   <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/" style="color: var(--primary);">
            <i class="bi bi-pie-chart-fill me-2"></i>BillSplit
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#features">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#pricing">Pricing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#testimonials">Testimonials</a>
                </li>
            </ul>
            <div class="ms-lg-3 mt-3 mt-lg-0">
                <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Sign Up Free</a>
            </div>
        </div>
    </div>
</nav>

    <!-- Hero Section -->
    <section class="hero-gradient text-white py-5">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <h1 class="display-4 fw-bold mb-4">Split bills with friends. Without the awkwardness.</h1>
                    <p class="lead mb-4">BillSplit makes it easy to track shared expenses and settle up with friends, roommates, or colleagues. No more spreadsheets or IOU notes.</p>
                    <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg px-4">Get Started</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="https://illustrations.popsy.co/amber/digital-nomad.svg" alt="BillSplit App" class="img-fluid">
                </div>
            </div>
        </div>
        <div class="wave-divider">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="#fff"></path>
                <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" fill="#fff"></path>
                <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="#fff"></path>
            </svg>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-number">10,000+</div>
                        <div class="stats-label">Active Users</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-number">500K+</div>
                        <div class="stats-label">Bills Split</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-number">$25M+</div>
                        <div class="stats-label">Tracked</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">Smart Features for Easy Splitting</h2>
                <p class="text-muted lead">Everything you need to track shared expenses and settle up</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h4>Group Expenses</h4>
                    <p class="text-muted">Create groups for roommates, trips, or events and track all shared expenses in one place.</p>
                </div>
                <div class="col-md-4">
                    <div class="feature-icon">
                        <i class="bi bi-cash-coin"></i>
                    </div>
                    <h4>Multiple Currencies</h4>
                    <p class="text-muted">Split bills in any currency with automatic conversion rates for international groups.</p>
                </div>
                <div class="col-md-4">
                    <div class="feature-icon">
                        <i class="bi bi-credit-card-2-back-fill"></i>
                    </div>
                    <h4>Payment Tracking</h4>
                    <p class="text-muted">Mark payments as settled and see who owes whom at a glance.</p>
                </div>
                <div class="col-md-4">
                    <div class="feature-icon">
                        <i class="bi bi-file-earmark-bar-graph-fill"></i>
                    </div>
                    <h4>Detailed Reports</h4>
                    <p class="text-muted">Visual breakdowns of spending patterns and individual contributions.</p>
                </div>
                <div class="col-md-4">
                    <div class="feature-icon">
                        <i class="bi bi-bell-fill"></i>
                    </div>
                    <h4>Reminders</h4>
                    <p class="text-muted">Automated reminders for unpaid balances to keep everyone accountable.</p>
                </div>
                <div class="col-md-4">
                    <div class="feature-icon">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>
                    <h4>Secure & Private</h4>
                    <p class="text-muted">Bank-level encryption keeps your financial data safe and private.</p>
                </div>
            </div>
        </div>
    </section>

    

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">Loved by Thousands</h2>
                <p class="text-muted lead">Don't just take our word for it</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="testimonial-card card h-100">
                        <div class="card-body p-4">
                            <div class="d-flex mb-3">
                                <img src="https://randomuser.me/api/portraits/women/32.jpg" class="rounded-circle me-3" width="50" height="50" alt="Sarah J.">
                                <div>
                                    <h6 class="mb-0">Sarah J.</h6>
                                    <small class="text-muted">Travel Enthusiast</small>
                                </div>
                            </div>
                            <p class="mb-0">"BillSplit saved our group trip to Bali! No more arguments about who paid for what. We could focus on enjoying our vacation instead of tracking expenses."</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card card h-100">
                        <div class="card-body p-4">
                            <div class="d-flex mb-3">
                                <img src="https://randomuser.me/api/portraits/men/45.jpg" class="rounded-circle me-3" width="50" height="50" alt="Michael T.">
                                <div>
                                    <h6 class="mb-0">Michael T.</h6>
                                    <small class="text-muted">College Student</small>
                                </div>
                            </div>
                            <p class="mb-0">"As a student sharing an apartment with 3 roommates, BillSplit has been a lifesaver. We use it for rent, utilities, groceries - everything!"</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card card h-100">
                        <div class="card-body p-4">
                            <div class="d-flex mb-3">
                                <img src="https://randomuser.me/api/portraits/women/68.jpg" class="rounded-circle me-3" width="50" height="50" alt="Priya K.">
                                <div>
                                    <h6 class="mb-0">Priya K.</h6>
                                    <small class="text-muted">Event Planner</small>
                                </div>
                            </div>
                            <p class="mb-0">"I organize team retreats for my company. BillSplit makes expense reimbursement so much easier - everyone can see exactly what they owe."</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-5 bg-light">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">Simple, Transparent Pricing</h2>
                <p class="text-muted lead">Choose the plan that works for you</p>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-md-4">
                    <div class="pricing-card card h-100">
                        <div class="card-header">
                            <h4 class="mb-0">Free</h4>
                        </div>
                        <div class="card-body p-4">
                            <div class="price mb-3">$0<span class="fs-6 text-muted">/month</span></div>
                            <ul class="list-unstyled mb-4">
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> 5 bills per month</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> 3 people per bill</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Basic expense tracking</li>
                                <li class="mb-2"><i class="bi bi-x-circle-fill text-muted me-2"></i> No advanced reports</li>
                                <li class="mb-2"><i class="bi bi-x-circle-fill text-muted me-2"></i> No payment reminders</li>
                            </ul>
                            <a href="/register" class="btn btn-outline-primary w-100">Get Started</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="pricing-card card h-100 featured">
                        <div class="featured-badge">Most Popular</div>
                        <div class="card-header">
                            <h4 class="mb-0">Premium</h4>
                        </div>
                        <div class="card-body p-4">
                            <div class="price mb-3">$4.99<span class="fs-6 text-muted">/month</span></div>
                            <ul class="list-unstyled mb-4">
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Unlimited bills</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Unlimited people</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Advanced expense tracking</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Detailed reports</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Automated reminders</li>
                            </ul>
                            <a href="{{ route('register') }}" class="btn btn-primary w-100">Upgrade Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 hero-gradient text-white">
        <div class="container py-5 text-center">
            <h2 class="fw-bold mb-4">Ready to simplify your shared expenses?</h2>
            <p class="lead mb-4">Join thousands of happy users who stopped worrying about who owes what.</p>
            <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5">Start Splitting for Free</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="text-white mb-4"><i class="bi bi-pie-chart-fill me-2"></i>BillSplit</h5>
                    <p>The smartest way to track shared expenses and settle up with friends, roommates, or colleagues.</p>
                    <div class="d-flex mt-4">
                        <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h6 class="text-white mb-4">Product</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#">Features</a></li>
                        <li class="mb-2"><a href="#">Pricing</a></li>
                        <li class="mb-2"><a href="#">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h6 class="text-white mb-4">Company</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#">About Us</a></li>
                        <li class="mb-2"><a href="#">Careers</a></li>
                        <li class="mb-2"><a href="#">Blog</a></li>
                        <li class="mb-2"><a href="#">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h6 class="text-white mb-4">Legal</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#">Privacy</a></li>
                        <li class="mb-2"><a href="#">Terms</a></li>
                        <li class="mb-2"><a href="#">Security</a></li>
                    </ul>
                </div>
                <div class="col-lg-2">
                    <h6 class="text-white mb-4">Download</h6>
                    <div class="d-flex flex-column gap-2">
                        <a href="#" class="btn btn-outline-light btn-sm"><i class="bi bi-apple me-2"></i>App Store</a>
                        <a href="#" class="btn btn-outline-light btn-sm"><i class="bi bi-google-play me-2"></i>Play Store</a>
                    </div>
                </div>
            </div>
            <hr class="my-4 bg-secondary">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">© 2023 BillSplit. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0">Made with <i class="bi bi-heart-fill text-danger"></i> for people who split bills</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>