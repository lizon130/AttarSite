@extends('frontend.layouts.app')

@section('title', 'Products | ' . Helper::getSettings('application_name') ?? 'Al-Noor')

<style>
    /* Attar page specific styles - core layout and widgets are defined in the main layout */

    /* --- Page Header --- */
    .page-header {
        background: linear-gradient(rgba(15, 61, 40, 0.85), rgba(15, 61, 40, 0.7)), url('https://picsum.photos/seed/desertnight/1920/600');
        background-size: cover;
        background-position: center;
        padding: 100px 0;
        color: #fff;
        text-align: center;
    }

    /* --- Sidebar Filters --- */
    .filter-sidebar {
        background: #fff;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        height: fit-content;
    }

    .filter-title {
        font-weight: 700;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #eee;
        color: var(--primary);
    }

    .list-group-item {
        border: none;
        padding: 8px 15px;
        color: #666;
        cursor: pointer;
    }

    .list-group-item:hover {
        background-color: transparent;
        color: var(--primary);
        padding-left: 20px;
    }

    .list-group-item.active {
        background-color: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    .form-check-input:checked {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    .price-range {
        width: 100%;
    }

    /* --- Scent Notes --- */
    .scent-note-card {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        border: 1px solid #eee;
    }

    .scent-note-card i {
        font-size: 2rem;
        margin-bottom: 10px;
    }

    .top-note i { color: #e17055; }
    .mid-note i { color: #fdcb6e; }
    .base-note i { color: #2d3436; }

    /* Product Card Enhancements */
    .product-card {
        position: relative;
        border: 1px solid #eee;
        border-radius: 10px;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        height: 100%;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .product-img-wrapper {
        position: relative;
        overflow: hidden;
        height: 250px;
    }

    .product-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
    }

    .product-card:hover .product-img-wrapper img {
        transform: scale(1.05);
    }

    .product-actions {
        position: absolute;
        bottom: -50px;
        left: 0;
        right: 0;
        background: rgba(255,255,255,0.9);
        padding: 10px;
        display: flex;
        justify-content: center;
        gap: 10px;
        transition: bottom 0.3s;
    }

    .product-card:hover .product-actions {
        bottom: 0;
    }

    .action-btn {
        background: white;
        border: 1px solid #ddd;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #333;
        transition: all 0.3s;
    }

    .action-btn:hover {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }
</style>

@section('content')

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">Premium Islamic Products</h1>
            <p class="lead mb-4">Discover our curated collection of authentic attars, tasbihs, and spiritual essentials</p>
        </div>
    </div>

    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Sidebar Filters -->
                <aside class="col-lg-3 mb-4">
                    <form id="filterForm" action="{{ route('public.product') }}" method="GET">
                        <div class="filter-sidebar">
                            <div class="filter-title">Categories</div>
                            <ul class="list-group list-group-flush mb-4">
                                <li class="list-group-item d-flex justify-content-between align-items-center {{ !request('category') ? 'active' : '' }}" 
                                    onclick="selectCategory('')">
                                    All Products <span class="badge bg-light text-dark rounded-pill">{{ $categories->sum('products_count') }}</span>
                                </li>
                                @foreach($categories as $category)
                                <li class="list-group-item d-flex justify-content-between align-items-center {{ request('category') == $category->id ? 'active' : '' }}"
                                    onclick="selectCategory('{{ $category->id }}')">
                                    {{ $category->categoryName }} <span class="badge bg-light text-dark rounded-pill">{{ $category->products_count }}</span>
                                </li>
                                @endforeach
                            </ul>

                            <div class="filter-title">Price Range</div>
                            <div class="row g-2 mb-3">
                                <div class="col">
                                    <input type="number" class="form-control form-control-sm" 
                                           name="min_price" 
                                           placeholder="Min" 
                                           value="{{ request('min_price') }}">
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control form-control-sm" 
                                           name="max_price" 
                                           placeholder="Max" 
                                           value="{{ request('max_price') }}">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-dark w-100 mt-4 rounded-pill">Apply Filters</button>
                            @if(request()->anyFilled(['category', 'min_price', 'max_price']))
                            <a href="{{ route('public.product') }}" class="btn btn-outline-secondary w-100 mt-2 rounded-pill">
                                Clear Filters
                            </a>
                            @endif
                        </div>
                        <input type="hidden" name="category" id="categoryInput" value="{{ request('category') }}">
                    </form>
                </aside>

                <!-- Product Grid -->
                <main class="col-lg-9">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="text-muted">
                            Showing {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} results
                        </span>
                        <select class="form-select w-auto border-0 bg-light" id="sortSelect" onchange="sortProducts(this.value)">
                            <option value="latest" {{ $sort == 'latest' ? 'selected' : '' }}>Sort by: Latest</option>
                            <option value="price_low" {{ $sort == 'price_low' ? 'selected' : '' }}>Sort by: Price: Low to High</option>
                            <option value="price_high" {{ $sort == 'price_high' ? 'selected' : '' }}>Sort by: Price: High to Low</option>
                            <option value="name" {{ $sort == 'name' ? 'selected' : '' }}>Sort by: Name</option>
                        </select>
                    </div>

                    @if($products->count() > 0)
                    <div class="row">
                        @foreach($products as $product)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="product-card">
                                <!-- Badges -->
                                @if($product->created_at->gt(now()->subDays(30)))
                                    <span class="position-absolute top-0 end-0 bg-primary text-white m-2 px-2 py-1 rounded small">New</span>
                                @elseif($product->OfferPrice && $product->Price > 0)
                                    @php
                                        $discount = round((($product->Price - $product->OfferPrice) / $product->Price) * 100);
                                    @endphp
                                    <span class="position-absolute top-0 end-0 bg-danger text-white m-2 px-2 py-1 rounded small">-{{ $discount }}%</span>
                                @endif
                                
                                <div class="product-img-wrapper">
                                    @if($product->primaryImage)
                                        <img src="{{ $product->primaryImage->image_url }}" 
                                             alt="{{ $product->ProductName }}">
                                    @else
                                        <img src="{{ asset('images/default-product.png') }}" 
                                             alt="{{ $product->ProductName }}">
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
                                    <div class="text-warning small mb-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= 4) <!-- Static rating for now, you can make dynamic -->
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="fas fa-star-half-alt"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <h5 class="fw-bold mb-1">{{ $product->ProductName }}</h5>
                                    <p class="text-muted small mb-2">{{ $product->category->categoryName ?? '' }}</p>
                                    
                                    <div class="mt-2">
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
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <nav aria-label="Page navigation" class="mt-5">
                        <div class="pagination justify-content-center">
                            {!! $products->withQueryString()->links() !!}
                        </div>
                    </nav>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No products found</h4>
                        <p class="text-muted">Try adjusting your filters or browse our other categories.</p>
                        <a href="{{ route('public.product') }}" class="btn btn-primary">Clear Filters</a>
                    </div>
                    @endif
                </main>
            </div>
        </div>
    </section>

    <!-- Scent Guide Section (Educational) -->
    <section class="bg-white py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h6 class="text-uppercase text-muted">Understanding Fragrance</h6>
                <h2 style="color: var(--primary);">The Scent Pyramid</h2>
                <p class="text-muted">Attars evolve on your skin. Discover the journey of our fragrances.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="scent-note-card top-note h-100">
                        <i class="fas fa-leaf"></i>
                        <h4>Top Notes</h4>
                        <p class="text-muted">The initial impression. Fresh, light, and volatile scents that evaporate
                            quickly. Think citrus or light spices.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="scent-note-card mid-note h-100">
                        <i class="fas fa-fan"></i>
                        <h4>Heart Notes</h4>
                        <p class="text-muted">The core of the fragrance. Appears after the top notes fade. Usually florals
                            like rose, jasmine, or herbs.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="scent-note-card base-note h-100">
                        <i class="fas fa-tree"></i>
                        <h4>Base Notes</h4>
                        <p class="text-muted">The lasting impression. Deep and rich woods, musk, or amber that stay on the
                            skin for hours.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Select category
    function selectCategory(categoryId) {
        document.getElementById('categoryInput').value = categoryId;
        document.getElementById('filterForm').submit();
    }

    // Sort products
    function sortProducts(sortBy) {
        const url = new URL(window.location.href);
        url.searchParams.set('sort', sortBy);
        window.location.href = url.toString();
    }

    // Add to cart
    $(document).on('click', '.add-to-cart', function() {
        const productId = $(this).data('id');
        $.ajax({
            url: '{{ route("cart.add") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                product_id: productId,
                quantity: 1
            },
            success: function(response) {
                toastr.success(response.message || 'Product added to cart!');
                updateCartCount();
            },
            error: function() {
                toastr.error('Please login to add to cart');
            }
        });
    });

    // Add to wishlist
    $(document).on('click', '.add-to-wishlist', function() {
        const productId = $(this).data('id');
        $.ajax({
            url: '#',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                product_id: productId
            },
            success: function(response) {
                toastr.success('Added to wishlist!');
            },
            error: function() {
                toastr.error('Please login to add to wishlist');
            }
        });
    });
</script>
@endpush