<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Al-Noor | Premium Islamic Store')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Outfit:wght@300;400;500;700&display=swap"
        rel="stylesheet">

    @stack('styles')

    <style>
        :root {
            --primary: #0f3d28;
            /* Deep Emerald */
            --secondary: #d4af37;
            /* Gold */
            --light-bg: #fdfbf7;
            /* Warm Cream */
            --dark-text: #2d3436;
        }

        body {
            font-family: 'Outfit', sans-serif;
            color: var(--dark-text);
            background-color: var(--light-bg);
            overflow-x: hidden;
        }

        h1,
        h2,
        h3,
        .font-arabic {
            font-family: 'Amiri', serif;
        }

        /* --- Top Bar --- */
        .top-bar {
            background-color: var(--primary);
            color: #fff;
            padding: 8px 0;
            font-size: 0.85rem;
        }

        .top-bar a {
            color: var(--secondary);
            text-decoration: none;
        }

        /* --- Navbar --- */
        .navbar {
            background: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 15px 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--primary);
        }

        .nav-link {
            font-weight: 500;
            color: #555;
            margin: 0 10px;
            position: relative;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: var(--secondary);
            transition: width 0.3s;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .badge-cart {
            background-color: var(--secondary);
            color: var(--primary);
        }

        /* --- Hero Section --- */
        .carousel-item {
            height: 80vh;
            min-height: 500px;
            background-size: cover;
            background-position: center;
        }

        .carousel-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(rgba(15, 61, 40, 0.7), rgba(15, 61, 40, 0.3));
        }

        .hero-content {
            position: relative;
            z-index: 2;
            color: #fff;
        }

        .btn-primary-custom {
            background-color: var(--secondary);
            color: var(--primary);
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary-custom:hover {
            background-color: #fff;
            color: var(--primary);
            transform: translateY(-3px);
        }

        .btn-outline-custom {
            border: 2px solid #fff;
            color: #fff;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            margin-left: 15px;
            transition: all 0.3s;
        }

        .btn-outline-custom:hover {
            background-color: #fff;
            color: var(--primary);
        }

        /* --- Sections Common --- */
        .section-padding {
            padding: 80px 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            color: var(--primary);
        }

        .section-title .divider {
            width: 80px;
            height: 3px;
            background: var(--secondary);
            margin: 10px auto;
        }

        /* --- Category Cards --- */
        .cat-card {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            height: 300px;
            cursor: pointer;
            margin-bottom: 30px;
        }

        .cat-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .cat-card:hover img {
            transform: scale(1.1);
        }

        .cat-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 30px;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
            color: #fff;
        }

        /* --- Product Cards --- */
        .product-card {
            border: none;
            background: #fff;
            border-radius: 15px;
            transition: all 0.3s;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
            position: relative;
            overflow: hidden;
        }

        .product-card:hover {
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            transform: translateY(-5px);
        }

        .product-img-wrapper {
            position: relative;
            overflow: hidden;
            height: 280px;
        }

        .product-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-actions {
            position: absolute;
            bottom: -50px;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: center;
            gap: 10px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.9);
            transition: bottom 0.3s ease;
        }

        .product-card:hover .product-actions {
            bottom: 0;
        }

        .action-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark-text);
            background: #fff;
            transition: all 0.2s;
        }

        .action-btn:hover {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }

        .badge-new {
            position: absolute;
            top: 15px;
            left: 15px;
            background: var(--primary);
            color: #fff;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            z-index: 10;
        }

        /* --- Features --- */
        .feature-box {
            text-align: center;
            padding: 30px;
            border: 1px solid #eee;
            border-radius: 10px;
            transition: all 0.3s;
        }

        .feature-box:hover {
            border-color: var(--secondary);
            background: #fff;
            transform: translateY(-5px);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 20px;
        }

        /* --- Footer --- */
        footer {
            background-color: #111;
            color: #aaa;
            padding-top: 70px;
        }

        footer h5 {
            color: #fff;
            margin-bottom: 25px;
            font-family: 'Amiri', serif;
            font-size: 1.4rem;
        }

        footer ul li {
            margin-bottom: 12px;
        }

        footer a {
            color: #aaa;
            text-decoration: none;
            transition: color 0.3s;
        }

        footer a:hover {
            color: var(--secondary);
        }

        .footer-bottom {
            background-color: #000;
            padding: 20px 0;
            margin-top: 50px;
        }

        /* Mobile Adjustments */
        @media (max-width: 768px) {
            .carousel-item {
                height: 60vh;
            }

            .hero-content h1 {
                font-size: 2.2rem;
            }

            .nav-link::after {
                display: none;
            }
        }
    </style>
</head>

<body>

    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container d-flex justify-content-between">
            <span><i class="fas fa-star me-2"></i>Free shipping on international orders over $100</span>
            <span class="d-none d-md-block"><i class="fas fa-phone-alt me-2"></i>Support: +123 456 789</span>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('public.homePage') }}">
                <i class="fas fa-kaaba me-2" style="color: var(--secondary);"></i>Al-Noor
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('public.homePage') ? 'active' : '' }}"
                            href="{{ route('public.homePage') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('public.product') ?? '#' }}">Shop</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('public.product') ?? '#' }}">Attar</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('public.product') ?? '#' }}">Tasbih</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <a href="#"><i class="fas fa-search fa-lg"></i></a>
                    <a href="#"><i class="far fa-heart fa-lg"></i></a>
                    <a href="#" class="position-relative">
                        <i class="fas fa-shopping-bag fa-lg"></i>
                        @auth
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill badge-cart">2</span>
                        @else
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill badge-cart">0</span>
                        @endauth
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <a class="navbar-brand text-white mb-3 d-block" href="{{ route('public.homePage') }}">Al-Noor</a>
                    <p>Your trusted destination for authentic Islamic goods. We strive to bring you the finest quality
                        Attars, Tasbihs, and spiritual accessories to enhance your daily worship.</p>
                    <div class="d-flex gap-3 mt-4">
                        <a href="#"
                            class="text-white border border-secondary rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px;"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"
                            class="text-white border border-secondary rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px;"><i class="fab fa-instagram"></i></a>
                        <a href="#"
                            class="text-white border border-secondary rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px;"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <div class="col-6 col-lg-2 mb-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">FAQs</a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-2 mb-4">
                    <h5>Categories</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Attar & Oud</a></li>
                        <li><a href="#">Tasbih</a></li>
                        <li><a href="#">Prayer Mats</a></li>
                        <li><a href="#">Books</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5>Contact Info</h5>
                    <ul class="list-unstyled">
                        <li class="mb-3"><i class="fas fa-map-marker-alt me-2" style="color: var(--secondary);"></i>
                            123 Islamic Center Road, Dubai, UAE</li>
                        <li class="mb-3"><i class="fas fa-phone me-2" style="color: var(--secondary);"></i> +971 50
                            123 4567</li>
                        <li><i class="fas fa-envelope me-2" style="color: var(--secondary);"></i> info@alnoor.com</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-bottom text-center">
            <div class="container">
                <p class="mb-0">&copy; {{ date('Y') }} Al-Noor Collections. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function updateCartCount() {
            fetch("{{ route('cart.count') }}").then(function(r){ return r.json(); }).then(function(res){
                document.querySelectorAll('.badge-cart').forEach(function(el){ el.textContent = res.count || 0; });
            }).catch(function(){});
        }
        document.addEventListener('DOMContentLoaded', function(){ updateCartCount(); });
    </script>

    @stack('scripts')
</body>

</html>