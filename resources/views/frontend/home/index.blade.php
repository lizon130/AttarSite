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
            <div class="carousel-item active"
                style="background-image: url('https://picsum.photos/seed/islamicart/1920/1080');">
                <div class="container h-100 d-flex align-items-center">
                    <div class="row hero-content">
                        <div class="col-lg-7">
                            <h1 class="display-3 fw-bold mb-3">Divine Fragrance <br> For The Soul</h1>
                            <p class="lead mb-4">Experience our premium collection of Oud, Musk, and traditional Attars.
                                Crafted for purity and spirituality.</p>
                            <a href="{{ route('public.product') ?? '#' }}" class="btn btn-primary-custom">Shop Attars</a>
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
                            <p class="lead mb-4">Handcrafted Tasbihs, elegant Tupis, and prayer essentials designed for the
                                modern believer.</p>
                            <a href="#collections" class="btn btn-primary-custom">Shop Essentials</a>
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
        <div class="row g-4 mt-3">
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
                @foreach ($categories as $category)
                    @php
                        // Try to find an active product to link to; otherwise link to filtered product listing
                        $firstProduct = $category->products()->where('status', 'active')->first();
                        $cardUrl = $firstProduct ? route('public.productDetails', $firstProduct->id) : route('public.product', ['category' => $category->id]);
                    @endphp
                    <div class="col-md-6 col-lg-4">
                        <div class="cat-card">
                            <a href="{{ $cardUrl }}">
                                <img src="https://picsum.photos/seed/perfume/600/800" alt="{{ $category->categoryName }}">
                            </a>
                            <div class="cat-overlay">
                                <h3><a href="{{ $cardUrl }}" class="text-white text-decoration-none">{{ $category->categoryName }}</a></h3>
                                <p class="mb-0">{{ $category->products()->count() ?? '0' }} Products</p>
                            </div>
                        </div>
                    </div>
                @endforeach    
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

        <!-- Dynamic Filters -->
        <ul class="nav justify-content-center mb-5">
            <li class="nav-item">
                <a class="nav-link active text-dark fw-bold" href="#" data-category="all">All</a>
            </li>
            @foreach($categories as $category)
                <li class="nav-item">
                    <a class="nav-link text-muted" href="#" 
                       data-category="{{ $category->id }}">
                        {{ $category->categoryName }}
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="row" id="product-container">
            @forelse($products as $product)
                <div class="col-md-6 col-lg-3 mb-4" data-category="{{ $product->CategoryId }}">
                    <div class="product-card">
                        <!-- Badge for new or discount -->
                        @if($product->created_at->gt(now()->subDays(30)))
                            <div class="badge-new">New</div>
                        @elseif($product->OfferPrice && $product->Price > 0)
                            @php
                                $discount = round((($product->Price - $product->OfferPrice) / $product->Price) * 100);
                            @endphp
                            <div class="badge-new">-{{ $discount }}%</div>
                        @endif
                        
                        <div class="product-img-wrapper">
                            <!-- Dynamic Image -->
                            @if($product->primaryImage)
                                <img src="{{ $product->primaryImage->image_url }}" 
                                     alt="{{ $product->ProductName }}"
                                     style="height: 250px; object-fit: cover;">
                            @else
                                <img src="{{ asset('images/default-product.png') }}" 
                                     alt="{{ $product->ProductName }}"
                                     style="height: 250px; object-fit: cover;">
                            @endif
                            
                            <div class="product-actions">
                                <button class="action-btn add-to-cart" data-id="{{ $product->id }}">
                                    <i class="fas fa-shopping-cart"></i>
                                </button>
                                <a href="{{ route('public.productDetails', $product->id) }}" class="action-btn">
                                    <i class="far fa-eye"></i>
                                </a>
                                <button class="action-btn add-to-wishlist" data-id="{{ $product->id }}">
                                    <i class="far fa-heart"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="p-3 text-center">
                            <!-- Category -->
                            <small class="text-muted">
                                {{ $product->category->categoryName ?? 'Uncategorized' }}
                            </small>
                            
                            <!-- Product Name -->
                            <h5 class="fw-bold mt-1">{{ $product->ProductName }}</h5>
                            
                            <!-- Rating (you can make this dynamic too if you have ratings) -->
                            <div class="text-warning mb-2">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            
                            <!-- Price -->
                            <div>
                                @if($product->OfferPrice && $product->OfferPrice < $product->Price)
                                    <span class="fs-5 fw-bold text-decoration-line-through text-muted me-2">
                                        ${{ number_format($product->Price, 2) }}
                                    </span>
                                    <span class="fs-5 fw-bold" style="color: var(--primary);">
                                        ${{ number_format($product->OfferPrice, 2) }}
                                    </span>
                                @else
                                    <span class="fs-5 fw-bold" style="color: var(--primary);">
                                        ${{ number_format($product->Price, 2) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">No products available yet.</p>
                </div>
            @endforelse
        </div>

        <div class="text-center mt-5">
            <a href="#" class="btn btn-outline-dark rounded-pill px-4">
                View All Products
            </a>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Filter products by category
    $(document).ready(function() {
        $('.nav-link[data-category]').click(function(e) {
            e.preventDefault();
            
            // Update active state
            $('.nav-link').removeClass('active text-dark fw-bold').addClass('text-muted');
            $(this).addClass('active text-dark fw-bold').removeClass('text-muted');
            
            const categoryId = $(this).data('category');
            const products = $('[data-category]');
            
            if (categoryId === 'all') {
                products.show();
            } else {
                products.each(function() {
                    if ($(this).data('category') == categoryId) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }
        });
        
        // Add to cart functionality
        $('.add-to-cart').click(function() {
            const productId = $(this).data('id');
            $.post('{{ route("cart.add") }}', { _token: '{{ csrf_token() }}', product_id: productId, quantity: 1 }, function(res) {
                toastr.success(res.message || 'Product added to cart');
                updateCartCount();
            }).fail(function() { toastr.error('Could not add to cart'); });
        });
        
        // Add to wishlist functionality
        $('.add-to-wishlist').click(function() {
            const productId = $(this).data('id');
            // Implement your wishlist logic here
            console.log('Add to wishlist:', productId);
        });
    });
</script>
@endpush

    <!-- Promo Section -->
    <section class="section-padding" style="background: var(--primary); color: #fff;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h2 class="font-arabic display-4 mb-3">Ramadan Collection</h2>
                    <p class="lead mb-4">Prepare for the holy month with our exclusive range of prayer mats, dates, and
                        spiritual gifts.</p>
                    <a href="#" class="btn btn-primary-custom text-white border-0"
                        style="background: var(--secondary);">Shop The Sale</a>
                </div>
                <div class="col-lg-6">
                    <img src="https://picsum.photos/seed/dates/800/400" class="img-fluid rounded-4 shadow-lg"
                        alt="Ramadan">
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
                        <p class="fs-4 fst-italic text-muted w-75 mx-auto">"The quality of the Oudh Attar is unmatched. It
                            lasts all day and the packaging was so elegant. Highly recommended!"</p>
                        <div class="mt-3">
                            <h5 class="fw-bold">Ahmed Al-Farsi</h5>
                            <div class="text-warning"><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                    class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        </div>
                    </div>
                    <div class="carousel-item text-center">
                        <p class="fs-4 fst-italic text-muted w-75 mx-auto">"Bought a tasbih for my father. The beads feel
                            premium and the shipping was incredibly fast to the UK."</p>
                        <div class="mt-3">
                            <h5 class="fw-bold">Sarah K.</h5>
                            <div class="text-warning"><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                    class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel"
                    data-bs-slide="prev" style="color: #000;">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel"
                    data-bs-slide="next" style="color: #000;">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </section>

    <!-- Instagram / Social Feed (Visual) -->
    <section class="py-5">
        <div class="container-fluid px-0">
            <div class="row g-0">
                <div class="col-6 col-md-3"><img src="https://picsum.photos/seed/islam1/400/400"
                        class="img-fluid w-100 h-100" style="object-fit: cover;" alt="Instagram"></div>
                <div class="col-6 col-md-3"><img src="https://picsum.photos/seed/islam2/400/400"
                        class="img-fluid w-100 h-100" style="object-fit: cover;" alt="Instagram"></div>
                <div class="col-6 col-md-3"><img src="https://picsum.photos/seed/islam3/400/400"
                        class="img-fluid w-100 h-100" style="object-fit: cover;" alt="Instagram"></div>
                <div class="col-6 col-md-3"><img src="https://picsum.photos/seed/islam4/400/400"
                        class="img-fluid w-100 h-100" style="object-fit: cover;" alt="Instagram"></div>
            </div>
            <div class="text-center py-4 bg-white">
                <a href="#" class="text-decoration-none fw-bold" style="color: var(--primary);">@AlNoorStore on
                    Instagram</a>
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
                    <input type="email" class="form-control form-control-lg rounded-pill"
                        placeholder="Enter your email">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-primary-custom w-100 rounded-pill">Subscribe</button>
                </div>
            </form>
        </div>
    </section>
@endsection
