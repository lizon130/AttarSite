@extends('frontend.layouts.app')

@section('title', 'Al-Noor | Premium Islamic Store')

@section('content')
    <!-- Hero Carousel -->
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
        </div>
        <div class="carousel-inner">
            <!-- Slide 1 -->
            <div class="carousel-item active" style="background-image: url('https://picsum.photos/seed/islamicart/1920/1080');">
                <div class="container h-100 d-flex align-items-center">
                    <div class="row hero-content">
                        <div class="col-lg-7">
                            <h1 class="display-3 fw-bold mb-3">Divine Fragrance <br> For The Soul</h1>
                            <p class="lead mb-4">Experience our premium collection of Oud, Musk, and traditional Attars. Crafted for purity and spirituality.</p>
                            <a href="{{ route('shop') ?? '#' }}" class="btn btn-primary-custom">Shop Attars</a>
                            <a href="#collections" class="btn btn-outline-custom">Explore More</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Slide 2 -->
            <div class="carousel-item" style="background-image: url('https://picsum.photos/seed/prayer/1920/1080');">
                <div class="container h-100 d-flex align-items-center">
                    <div class="row hero-content">
                        <div class="col-lg-7">
                            <h1 class="display-3 fw-bold mb-3">Elevate Your <br>Spiritual Journey</h1>
                            <p class="lead mb-4">Handcrafted Tasbihs, elegant Tupis, and prayer essentials designed for the modern believer.</p>
                            <a href="{{ route('shop') ?? '#' }}" class="btn btn-primary-custom">Shop Essentials</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>

    <!-- Features Banner -->
    <div class="container mt-n5 position-relative" style="z-index: 10;">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-box bg-white shadow-sm">
                    <i class="fas fa-mosque feature-icon"></i>
                    <h4>Authenticity Guaranteed</h4>
                    <p class="text-muted small">100% pure and alcohol-free products sourced directly.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box bg-white shadow-sm">
                    <i class="fas fa-hand-holding-heart feature-icon"></i>
                    <h4>Ethically Sourced</h4>
                    <p class="text-muted small">Handcrafted with care respecting traditional methods.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box bg-white shadow-sm">
                    <i class="fas fa-shipping-fast feature-icon"></i>
                    <h4>Global Delivery</h4>
                    <p class="text-muted small">Fast and secure shipping to over 50 countries.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories -->
    <section class="section-padding" id="collections">
        <div class="container">
            <div class="section-title">
                <span class="text-uppercase text-muted letter-spacing-2">Browse</span>
                <h2>Shop By Category</h2>
                <div class="divider"></div>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-4">
                    <div class="cat-card">
                        <img src="https://picsum.photos/seed/perfume/600/800" alt="Attar">
                        <div class="cat-overlay">
                            <h3>Premium Attars</h3>
                            <p class="mb-0">35 Products</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="cat-card">
                        <img src="https://picsum.photos/seed/beads/600/800" alt="Tasbih">
                        <div class="cat-overlay">
                            <h3>Misbaha & Tasbih</h3>
                            <p class="mb-0">22 Products</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="cat-card">
                        <img src="https://picsum.photos/seed/cloth/600/800" alt="Tupi">
                        <div class="cat-overlay">
                            <h3>Tupi & Apparel</h3>
                            <p class="mb-0">18 Products</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Grid -->
    <section class="section-padding bg-white" id="shop">
        <div class="container">
            <div class="section-title">
                <span class="text-uppercase text-muted letter-spacing-2">New Arrivals</span>
                <h2>Trending Products</h2>
                <div class="divider"></div>
            </div>

            <!-- Filters (Visual Only) -->
            <ul class="nav justify-content-center mb-5">
                <li class="nav-item"><a class="nav-link active text-dark fw-bold" href="#">All</a></li>
                <li class="nav-item"><a class="nav-link text-muted" href="{{ route('attar') ?? '#' }}">Attars</a></li>
                <li class="nav-item"><a class="nav-link text-muted" href="{{ route('tasbih') ?? '#' }}">Tasbih</a></li>
                <li class="nav-item"><a class="nav-link text-muted" href="#">Tupi</a></li>
            </ul>

            <div class="row">
                <!-- Product 1 -->
                <div class="col-md-6 col-lg-3">
                    <div class="product-card">
                        <div class="badge-new">New</div>
                        <div class="product-img-wrapper">
                            <img src="https://picsum.photos/seed/oudh/400/400" alt="Oudh">
                            <div class="product-actions">
                                <button class="action-btn"><i class="fas fa-shopping-cart"></i></button>
                                <button class="action-btn"><i class="far fa-eye"></i></button>
                                <button class="action-btn"><i class="far fa-heart"></i></button>
                            </div>
                        </div>
                        <div class="p-3 text-center">
                            <small class="text-muted">Attar</small>
                            <h5 class="fw-bold mt-1">Royal Oudh 12ml</h5>
                            <div class="text-warning mb-2">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="fs-5 fw-bold" style="color: var(--primary);">$25.00</span>
                        </div>
                    </div>
                </div>

                <!-- Product 2 -->
                <div class="col-md-6 col-lg-3">
                    <div class="product-card">
                        <div class="product-img-wrapper">
                            <img src="https://picsum.photos/seed/rosary/400/400" alt="Tasbih">
                            <div class="product-actions">
                                <button class="action-btn"><i class="fas fa-shopping-cart"></i></button>
                                <button class="action-btn"><i class="far fa-eye"></i></button>
                                <button class="action-btn"><i class="far fa-heart"></i></button>
                            </div>
                        </div>
                        <div class="p-3 text-center">
                            <small class="text-muted">Tasbih</small>
                            <h5 class="fw-bold mt-1">Agate Stone Beads</h5>
                            <div class="text-warning mb-2">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
                            </div>
                            <span class="fs-5 fw-bold" style="color: var(--primary);">$18.50</span>
                        </div>
                    </div>
                </div>

                <!-- Product 3 -->
                <div class="col-md-6 col-lg-3">
                    <div class="product-card">
                        <div class="badge-new">-20%</div>
                        <div class="product-img-wrapper">
                            <img src="https://picsum.photos/seed/whitecap/400/400" alt="Cap">
                            <div class="product-actions">
                                <button class="action-btn"><i class="fas fa-shopping-cart"></i></button>
                                <button class="action-btn"><i class="far fa-eye"></i></button>
                                <button class="action-btn"><i class="far fa-heart"></i></button>
                            </div>
                        </div>
                        <div class="p-3 text-center">
                            <small class="text-muted">Tupi</small>
                            <h5 class="fw-bold mt-1">Embroidered White Cap</h5>
                            <div class="text-warning mb-2">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <span class="fs-5 fw-bold text-decoration-line-through text-muted me-2">$15.00</span>
                            <span class="fs-5 fw-bold" style="color: var(--primary);">$12.00</span>
                        </div>
                    </div>
                </div>

                <!-- Product 4 -->
                <div class="col-md-6 col-lg-3">
                    <div class="product-card">
                        <div class="product-img-wrapper">
                            <img src="https://picsum.photos/seed/oillamp/400/400" alt="Bakhoor">
                            <div class="product-actions">
                                <button class="action-btn"><i class="fas fa-shopping-cart"></i></button>
                                <button class="action-btn"><i class="far fa-eye"></i></button>
                                <button class="action-btn"><i class="far fa-heart"></i></button>
                            </div>
                        </div>
                        <div class="p-3 text-center">
                            <small class="text-muted">Home</small>
                            <h5 class="fw-bold mt-1">Luxury Bakhoor Set</h5>
                            <div class="text-warning mb-2">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <span class="fs-5 fw-bold" style="color: var(--primary);">$32.00</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5">
                <a href="{{ route('shop') ?? '#' }}" class="btn btn-outline-dark rounded-pill px-4">View All Products</a>
            </div>
        </div>
    </section>

    <!-- Promo Section -->
    <section class="section-padding" style="background: var(--primary); color: #fff;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h2 class="font-arabic display-4 mb-3">Ramadan Collection</h2>
                    <p class="lead mb-4">Prepare for the holy month with our exclusive range of prayer mats, dates, and spiritual gifts.</p>
                    <a href="#" class="btn btn-primary-custom text-white border-0" style="background: var(--secondary);">Shop The Sale</a>
                </div>
                <div class="col-lg-6">
                    <img src="https://picsum.photos/seed/dates/800/400" class="img-fluid rounded-4 shadow-lg" alt="Ramadan">
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="section-padding bg-light">
        <div class="container">
            <div class="section-title">
                <h2>What Our Customers Say</h2>
                <div class="divider"></div>
            </div>
            <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active text-center">
                        <p class="fs-4 fst-italic text-muted w-75 mx-auto">"The quality of the Oudh Attar is unmatched. It lasts all day and the packaging was so elegant. Highly recommended!"</p>
                        <div class="mt-3">
                            <h5 class="fw-bold">Ahmed Al-Farsi</h5>
                            <div class="text-warning"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        </div>
                    </div>
                    <div class="carousel-item text-center">
                        <p class="fs-4 fst-italic text-muted w-75 mx-auto">"Bought a tasbih for my father. The beads feel premium and the shipping was incredibly fast to the UK."</p>
                        <div class="mt-3">
                            <h5 class="fw-bold">Sarah K.</h5>
                            <div class="text-warning"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev" style="color: #000;">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next" style="color: #000;">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </section>

    <!-- Instagram / Social Feed (Visual) -->
    <section class="py-5">
        <div class="container-fluid px-0">
            <div class="row g-0">
                <div class="col-6 col-md-3"><img src="https://picsum.photos/seed/islam1/400/400" class="img-fluid w-100 h-100" style="object-fit: cover;" alt="Instagram"></div>
                <div class="col-6 col-md-3"><img src="https://picsum.photos/seed/islam2/400/400" class="img-fluid w-100 h-100" style="object-fit: cover;" alt="Instagram"></div>
                <div class="col-6 col-md-3"><img src="https://picsum.photos/seed/islam3/400/400" class="img-fluid w-100 h-100" style="object-fit: cover;" alt="Instagram"></div>
                <div class="col-6 col-md-3"><img src="https://picsum.photos/seed/islam4/400/400" class="img-fluid w-100 h-100" style="object-fit: cover;" alt="Instagram"></div>
            </div>
            <div class="text-center py-4 bg-white">
                <a href="#" class="text-decoration-none fw-bold" style="color: var(--primary);">@AlNoorStore on Instagram</a>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="section-padding bg-white text-center">
        <div class="container">
            <i class="far fa-paper-plane fa-3x mb-3" style="color: var(--secondary);"></i>
            <h3 class="mb-3">Join Our Newsletter</h3>
            <p class="text-muted mb-4">Sign up for exclusive offers, Islamic updates, and new arrival alerts.</p>
            <form class="row justify-content-center g-2">
                <div class="col-md-5">
                    <input type="email" class="form-control form-control-lg rounded-pill" placeholder="Enter your email">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-primary-custom w-100 rounded-pill">Subscribe</button>
                </div>
            </form>
        </div>
    </section>
@endsection