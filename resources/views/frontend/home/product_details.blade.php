@extends('frontend.layouts.app')

@section('title', $product->ProductName . ' | ' . Helper::getSettings('application_name') ?? 'Al-Noor')
@section('content')
<style>
    /* Product details - page-specific styles only */

    /* Accent utility */
    .accent { color: var(--primary); }

    /* Breadcrumb */
    .breadcrumb-item a { color: #888; text-decoration: none; }
    .breadcrumb-item.active { color: var(--primary); }

    /* Product Gallery */
    .main-image { border-radius: 15px; overflow: hidden; border: 1px solid #eee; margin-bottom: 15px; background: #fff; }
    .main-image img { width: 100%; height: auto; object-fit: cover; transition: transform 0.3s; }
    .thumb-img { cursor: pointer; border: 2px solid transparent; border-radius: 10px; overflow: hidden; transition: all 0.3s; }
    .thumb-img.active, .thumb-img:hover { border-color: var(--secondary); opacity: 0.8; }
    .thumb-img img { width: 100%; height: 80px; object-fit: cover; }

    /* Product Info */
    .product-meta { color: #888; font-size: 0.9rem; margin-bottom: 15px; }
    .product-meta i { color: #f1c40f; margin-right: 5px; }
    .price-tag { font-size: 2.5rem; font-weight: 700; color: var(--primary); font-family: 'Amiri', serif; }
    .old-price { text-decoration: line-through; color: #aaa; font-size: 1.5rem; margin-left: 10px; }

    /* Options */
    .option-label { font-weight: 600; font-size: 0.9rem; margin-bottom: 10px; display: block; }
    .size-btn { width: 50px; height: 40px; border: 1px solid #ddd; background: #fff; display: inline-flex; align-items: center; justify-content: center; margin-right: 10px; border-radius: 5px; cursor: pointer; transition: all 0.2s; }
    .size-btn:hover, .size-btn.active { border-color: var(--primary); background: var(--primary); color: #fff; }

    /* Quantity & Cart */
    .qty-input { width: 60px; text-align: center; border: 1px solid #ddd; height: 50px; border-radius: 5px; }
    .qty-btn { width: 40px; height: 50px; border: 1px solid #ddd; background: #f9f9f9; border-radius: 5px; cursor: pointer; }
    .btn-cart { background-color: var(--primary); color: #fff; padding: 12px 30px; border-radius: 5px; font-weight: 600; border: none; width: 100%; transition: all 0.3s; }
    .btn-cart:hover { background-color: var(--secondary); color: var(--primary); }
    .btn-wishlist { border: 1px solid #ddd; background: #fff; color: #555; padding: 12px; border-radius: 5px; width: 100%; margin-top: 15px; font-weight: 600; transition: all 0.3s; }
    .btn-wishlist:hover { border-color: #e74c3c; color: #e74c3c; background: #fff5f5; }

    /* Tabs */
    .nav-tabs .nav-link { color: #555; border: none; border-bottom: 3px solid transparent; font-weight: 500; padding: 15px 20px; }
    .nav-tabs .nav-link.active { color: var(--primary); border-bottom: 3px solid var(--secondary); background: transparent; }
    .nav-tabs .nav-link:hover { border-color: transparent; color: var(--primary); }

    /* Features Checklist */
    .feature-check { display: flex; align-items: center; margin-bottom: 10px; font-size: 0.9rem; color: #555; }
    .feature-check i { color: var(--primary); margin-right: 10px; background: #e8f5e9; padding: 5px; border-radius: 50%; font-size: 0.8rem; }

    /* Sticky Sidebar (Desktop) */
    @media (min-width: 992px) { .sticky-sidebar { position: sticky; top: 100px; } }
</style>

    <!-- Breadcrumb -->
    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('public.homePage') }}">Home</a></li>
                <li class="breadcrumb-item">
                    <a href="{{ route('public.product') }}">{{ $product->category->categoryName ?? 'Products' }}</a>
                </li>
                @if($product->subCategory)
                <li class="breadcrumb-item">
                    <a href="#">{{ $product->subCategory->SubCategoryName }}</a>
                </li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ $product->ProductName }}</li>
            </ol>
        </nav>
    </div>

    <!-- Product Details Section -->
    <section class="py-4">
        <div class="container">
            <div class="row gy-5">
                
                <!-- Left: Product Gallery -->
                <div class="col-lg-6">
                    <div class="main-image">
                        <img src="{{ $product->images->isNotEmpty() ? asset('storage/' . $product->images->first()->image_path) : asset('images/default-product.png') }}" 
                             id="mainProductImage" 
                             alt="{{ $product->ProductName }}"
                             style="max-height: 500px; object-fit: contain;">
                    </div>
                    
                    @if($product->images->count() > 1)
                    <div class="row g-2">
                        @foreach($product->images as $index => $image)
                        <div class="col-3">
                            <div class="thumb-img {{ $index === 0 ? 'active' : '' }}" 
                                 onclick="changeImage(this, '{{ asset('storage/' . $image->image_path) }}')">
                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                     alt="Thumb {{ $index + 1 }}">
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Right: Product Info -->
                <div class="col-lg-6">
                    <div class="sticky-sidebar">
                        <h2 class="fw-bold mb-2 accent">{{ $product->ProductName }}</h2>
                        
                        <div class="product-meta">
                            <span><i class="fas fa-star"></i> 
                                @php
                                    $avgRating = $product->reviews->avg('rating') ?? 0;
                                    $reviewCount = $product->reviews->count();
                                @endphp
                                {{ number_format($avgRating, 1) }} ({{ $reviewCount }} Reviews)
                            </span> &nbsp;|&nbsp; 
                            <span><i class="fas fa-check-circle"></i> 
                                {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                            </span>
                        </div>

                        <div class="my-3">
                            @if($product->OfferPrice && $product->OfferPrice < $product->Price)
                                <span class="price-tag">${{ number_format($product->OfferPrice, 2) }}</span>
                                <span class="old-price">${{ number_format($product->Price, 2) }}</span>
                                <span class="badge bg-danger ms-2">
                                    {{ round((($product->Price - $product->OfferPrice) / $product->Price) * 100) }}% OFF
                                </span>
                            @else
                                <span class="price-tag">${{ number_format($product->Price, 2) }}</span>
                            @endif
                        </div>

                        <p class="text-muted lead mb-4">
                            {{ $product->ProductDetails ?? 'No description available.' }}
                        </p>

                        <!-- Size/Variant -->
                        @if($product->ProductSize)
                        <div class="mb-4">
                            <span class="option-label">Size/Variant:</span>
                            <div>
                                <div class="size-btn active">{{ $product->ProductSize }}</div>
                            </div>
                        </div>
                        @endif

                        <!-- Quantity & Actions -->
                        <div class="row g-2 mb-4">
                            <div class="col-auto">
                                <div class="input-group">
                                    <button class="qty-btn" onclick="adjustQty(-1)">-</button>
                                    <input type="text" class="qty-input" value="1" id="qtyValue" readonly>
                                    <button class="qty-btn" onclick="adjustQty(1)">+</button>
                                </div>
                            </div>
                            <div class="col">
                                <button class="btn-cart" onclick="cartFunctions.addToCart({{ $product->id }}, document.getElementById('qtyValue').value)" 
        {{ $product->stock <= 0 ? 'disabled' : '' }}>
    <i class="fas fa-shopping-bag me-2"></i> 
    {{ $product->stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
</button>
                            </div>
                        </div>

                        <button class="btn-wishlist" onclick="addToWishlist({{ $product->id }})">
                            <i class="far fa-heart me-2"></i> Add to Wishlist
                        </button>

                        <!-- Product Meta -->
                        <div class="mt-4 pt-4 border-top">
                            <div class="row small">
                                <div class="col-6 mb-2">
                                    <strong>Category:</strong> {{ $product->category->categoryName ?? 'N/A' }}
                                </div>
                                <div class="col-6 mb-2">
                                    <strong>SKU:</strong> PROD{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}
                                </div>
                                <div class="col-6 mb-2">
                                    <strong>Status:</strong> 
                                    <span class="badge bg-{{ $product->status == 'active' ? 'success' : 'danger' }}">
                                        {{ ucfirst($product->status) }}
                                    </span>
                                </div>
                                <div class="col-6 mb-2">
                                    <strong>Stock:</strong> {{ $product->stock ?? 'N/A' }}
                                </div>
                            </div>
                        </div>

                        <!-- Trust Badges -->
                        <div class="mt-4 pt-4 border-top">
                            <div class="feature-check">
                                <i class="fas fa-shipping-fast"></i> Free Shipping on orders over $50
                            </div>
                            <div class="feature-check">
                                <i class="fas fa-undo"></i> 30-Day Return Policy
                            </div>
                            <div class="feature-check">
                                <i class="fas fa-shield-alt"></i> Secure Payment
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Product Description Tabs -->
    <section class="bg-white py-5">
        <div class="container">
            <ul class="nav nav-tabs mb-4 justify-content-center justify-content-lg-start" id="productTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc" type="button">Description</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button">
                        Reviews ({{ $reviewCount }})
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="productTabContent">
                <!-- Description -->
                <div class="tab-pane fade show active" id="desc">
                    <div class="row">
                        <div class="col-lg-8">
                            <h4 class="font-arabic mb-3">Product Details</h4>
                            <p class="text-muted">
                                {!! nl2br(e($product->ProductDetails ?? 'No detailed description available.')) !!}
                            </p>
                            
                            @if($product->category || $product->subCategory)
                            <div class="mt-4">
                                <h5>Product Information</h5>
                                <table class="table table-bordered">
                                    <tbody>
                                        @if($product->category)
                                        <tr>
                                            <td width="30%"><strong>Category</strong></td>
                                            <td>{{ $product->category->categoryName }}</td>
                                        </tr>
                                        @endif
                                        @if($product->subCategory)
                                        <tr>
                                            <td><strong>Sub Category</strong></td>
                                            <td>{{ $product->subCategory->SubCategoryName }}</td>
                                        </tr>
                                        @endif
                                        @if($product->ProductSize)
                                        <tr>
                                            <td><strong>Size/Variant</strong></td>
                                            <td>{{ $product->ProductSize }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td><strong>Regular Price</strong></td>
                                            <td>${{ number_format($product->Price, 2) }}</td>
                                        </tr>
                                        @if($product->OfferPrice)
                                        <tr>
                                            <td><strong>Offer Price</strong></td>
                                            <td class="text-success">${{ number_format($product->OfferPrice, 2) }}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Reviews -->
                <div class="tab-pane fade" id="reviews">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="border p-3 rounded bg-light">
                                <h5 class="fw-bold">{{ number_format($avgRating, 1) }} out of 5</h5>
                                <div class="text-warning mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($avgRating))
                                            <i class="fas fa-star"></i>
                                        @elseif($i - 0.5 <= $avgRating)
                                            <i class="fas fa-star-half-alt"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <p class="small text-muted">Based on {{ $reviewCount }} reviews</p>
                                <hr>
                                <button class="btn btn-outline-dark btn-sm w-100" data-bs-toggle="modal" data-bs-target="#reviewModal">
                                    Write a Review
                                </button>
                            </div>
                        </div>
                        <div class="col-md-8">
                            @forelse($product->reviews as $review)
                            <div class="mb-4 border-bottom pb-3">
                                <div class="d-flex justify-content-between">
                                    <h6 class="fw-bold mb-1">{{ $review->user->name ?? 'Anonymous' }}</h6>
                                    <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                </div>
                                <div class="text-warning small mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <p class="mb-0 text-muted">"{{ $review->comment }}"</p>
                            </div>
                            @empty
                            <div class="text-center py-4">
                                <p class="text-muted">No reviews yet. Be the first to review this product!</p>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reviewModal">
                                    Write First Review
                                </button>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <section class="py-5">
        <div class="container">
            <h3 class="text-center mb-5 font-arabic accent">You May Also Like</h3>
            <div class="row">
                @foreach($relatedProducts as $relatedProduct)
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card border-0 shadow-sm h-100 product-card">
                        <div class="product-img-wrapper">
                            <img src="{{ $relatedProduct->images->isNotEmpty() ? asset('storage/' . $relatedProduct->images->first()->image_path) : asset('images/default-product.png') }}" 
                                 class="card-img-top" 
                                 alt="{{ $relatedProduct->ProductName }}"
                                 style="height: 250px; object-fit: cover;">
                            <div class="product-actions">
                                <button class="action-btn add-to-cart" data-id="{{ $relatedProduct->id }}">
                                    <i class="fas fa-shopping-cart"></i>
                                </button>
                                <a href="{{ route('public.productDetails', $relatedProduct->id) }}" class="action-btn">
                                    <i class="far fa-eye"></i>
                                </a>
                                <button class="action-btn add-to-wishlist" data-id="{{ $relatedProduct->id }}">
                                    <i class="far fa-heart"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <h6 class="fw-bold mb-1">{{ $relatedProduct->ProductName }}</h6>
                            <p class="text-muted small mb-2">{{ $relatedProduct->category->categoryName ?? '' }}</p>
                            <div class="mb-2">
                                @if($relatedProduct->OfferPrice && $relatedProduct->OfferPrice < $relatedProduct->Price)
                                    <span class="text-decoration-line-through text-muted me-2">
                                        ${{ number_format($relatedProduct->Price, 2) }}
                                    </span>
                                    <span class="fw-bold text-success">
                                        ${{ number_format($relatedProduct->OfferPrice, 2) }}
                                    </span>
                                @else
                                    <span class="fw-bold text-success">
                                        ${{ number_format($relatedProduct->Price, 2) }}
                                    </span>
                                @endif
                            </div>
                            <a href="{{ route('public.productDetails', $relatedProduct->id) }}" 
                               class="btn btn-sm btn-outline-primary w-100">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Review Modal -->
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Write a Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="reviewForm">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <div class="rating-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="far fa-star" data-rating="{{ $i }}" style="cursor:pointer; font-size: 1.5rem;"></i>
                                @endfor
                                <input type="hidden" name="rating" id="ratingValue" value="5" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Your Review</label>
                            <textarea class="form-control" name="comment" rows="4" placeholder="Share your experience with this product..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Review</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Image gallery functionality
    function changeImage(element, imageUrl) {
        // Update main image
        document.getElementById('mainProductImage').src = imageUrl;
        
        // Update active thumbnail
        document.querySelectorAll('.thumb-img').forEach(thumb => {
            thumb.classList.remove('active');
        });
        element.classList.add('active');
    }

    // Quantity adjustment
    function adjustQty(change) {
        const qtyInput = document.getElementById('qtyValue');
        let currentQty = parseInt(qtyInput.value);
        currentQty += change;
        if (currentQty < 1) currentQty = 1;
        if (currentQty > 10) currentQty = 10; // Max quantity
        qtyInput.value = currentQty;
    }

    // Add to cart using global cart.js
    function addToCart(productId) {
        const quantity = document.getElementById('qtyValue').value;
        cartFunctions.addToCart(productId, parseInt(quantity));
    }

    // Add to wishlist
    function addToWishlist(productId) {
        $.ajax({
            url: '#',
            method: 'POST',
            data: {
                _token: cartFunctions.getCsrfToken(),
                product_id: productId
            },
            success: function(response) {
                toastr.success('Added to wishlist!');
            },
            error: function() {
                toastr.error('Please login to add to wishlist');
            }
        });
    }

    // Rating stars
    $(document).ready(function() {
        // Star rating
        $('.rating-stars .fa-star').click(function() {
            const rating = $(this).data('rating');
            $('#ratingValue').val(rating);
            
            // Update stars display
            $('.rating-stars .fa-star').each(function(i) {
                if (i < rating) {
                    $(this).removeClass('far').addClass('fas');
                } else {
                    $(this).removeClass('fas').addClass('far');
                }
            });
        });

        // Review form submission
        $('#reviewForm').submit(function(e) {
            e.preventDefault();
            
            $.ajax({
                url: '#',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    toastr.success('Review submitted successfully!');
                    $('#reviewModal').modal('hide');
                    location.reload(); // Reload to show new review
                },
                error: function() {
                    toastr.error('Please login to submit a review');
                }
            });
        });

        // Add to cart for related products
        $(document).on('click', '.add-to-cart', function(e) {
            e.preventDefault();
            const productId = $(this).data('id');
            cartFunctions.addToCart(productId, 1);
        });
    });
</script>
@endpush