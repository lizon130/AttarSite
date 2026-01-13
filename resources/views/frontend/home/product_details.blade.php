@extends('frontend.layouts.app')

@section('title', 'Al-Noor | Premium Islamic Store')
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
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item"><a href="attar-page.html">Attar</a></li>
                <li class="breadcrumb-item"><a href="#">Oudh & Agarwood</a></li>
                <li class="breadcrumb-item active" aria-current="page">Royal Cambodi Oudh</li>
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
                        <img src="https://picsum.photos/seed/oudhroyal/800/800" id="mainProductImage" alt="Product Main">
                    </div>
                    <div class="row g-2">
                        <div class="col-3">
                            <div class="thumb-img active" onclick="changeImage(this)">
                                <img src="https://picsum.photos/seed/oudhroyal/800/800" alt="Thumb 1">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="thumb-img" onclick="changeImage(this)">
                                <img src="https://picsum.photos/seed/attarbottle/800/800" alt="Thumb 2">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="thumb-img" onclick="changeImage(this)">
                                <img src="https://picsum.photos/seed/oiltexture/800/800" alt="Thumb 3">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="thumb-img" onclick="changeImage(this)">
                                <img src="https://picsum.photos/seed/boxgift/800/800" alt="Thumb 4">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Product Info -->
                <div class="col-lg-6">
                    <div class="sticky-sidebar">
                        <h2 class="fw-bold mb-2 accent">Royal Cambodi Oudh</h2>
                        
                        <div class="product-meta">
                            <span><i class="fas fa-star"></i> 4.9 (128 Reviews)</span> &nbsp;|&nbsp; 
                            <span><i class="fas fa-check-circle"></i> In Stock</span>
                        </div>

                        <div class="my-3">
                            <span class="price-tag">$45.00</span>
                            <span class="old-price">$55.00</span>
                        </div>

                        <p class="text-muted lead mb-4">
                            Experience the deep, smoky, and woody aroma of authentic Cambodian Oudh. A long-lasting, alcohol-free fragrance perfect for special occasions and daily wear.
                        </p>

                        <!-- Options (Size) -->
                        <div class="mb-4">
                            <span class="option-label">Select Size (Volume):</span>
                            <div>
                                <div class="size-btn active">6ml</div>
                                <div class="size-btn">12ml</div>
                                <div class="size-btn">24ml</div>
                            </div>
                        </div>

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
                                <button class="btn-cart">
                                    <i class="fas fa-shopping-bag me-2"></i> Add to Cart
                                </button>
                            </div>
                        </div>

                        <button class="btn-wishlist">
                            <i class="far fa-heart me-2"></i> Add to Wishlist
                        </button>

                        <!-- Trust Badges -->
                        <div class="mt-4 pt-4 border-top">
                            <div class="feature-check">
                                <i class="fas fa-shipping-fast"></i> Free Shipping on orders over $50
                            </div>
                            <div class="feature-check">
                                <i class="fas fa-leaf"></i> 100% Alcohol Free & Natural
                            </div>
                            <div class="feature-check">
                                <i class="fas fa-undo"></i> 30-Day Return Policy
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
                    <button class="nav-link" id="ingredients-tab" data-bs-toggle="tab" data-bs-target="#ingredients" type="button">Ingredients</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button">Reviews (128)</button>
                </li>
            </ul>

            <div class="tab-content" id="productTabContent">
                <!-- Description -->
                <div class="tab-pane fade show active" id="desc">
                    <div class="row">
                        <div class="col-lg-8">
                            <h4 class="font-arabic mb-3">A Scent of Royalty</h4>
                            <p class="text-muted">
                                Our Royal Cambodi Oudh is distilled from the heartwood of Aquilaria trees found in the dense forests of Cambodia. Known for its complex profile, this attar opens with a smoky intensity that settles into a sweet, leathery, and woody finish.
                            </p>
                            <p class="text-muted">
                                Unlike synthetic perfumes, pure Oudh oil interacts with your skin's natural pH to create a unique scent signature that lasts for hours.
                            </p>
                            <ul class="list-unstyled mt-3 text-muted">
                                <li><i class="fas fa-check text-success me-2"></i> Pure Oudh Oil (Dehn al Oudh)</li>
                                <li><i class="fas fa-check text-success me-2"></i> Steam Distilled</li>
                                <li><i class="fas fa-check text-success me-2"></i> Unisex Fragrance</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Ingredients -->
                <div class="tab-pane fade" id="ingredients">
                    <div class="col-lg-6">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Ingredient</th>
                                    <th>Origin</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Agarwood Oil (Oudh)</td>
                                    <td>Cambodia</td>
                                </tr>
                                <tr>
                                    <td>Sandalwood Oil (Base)</td>
                                    <td>India (Mysore)</td>
                                </tr>
                                <tr>
                                    <td>Jojoba Carrier Oil</td>
                                    <td>Organic</td>
                                </tr>
                            </tbody>
                        </table>
                        <p class="text-muted small mt-2">*This product does not contain any alcohol or synthetic chemicals.</p>
                    </div>
                </div>

                <!-- Reviews -->
                <div class="tab-pane fade" id="reviews">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="border p-3 rounded bg-light">
                                <h5 class="fw-bold">4.8 out of 5</h5>
                                <div class="text-warning mb-2"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i></div>
                                <p class="small text-muted">Based on 128 reviews</p>
                                <hr>
                                <button class="btn btn-outline-dark btn-sm w-100">Write a Review</button>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <!-- Single Review -->
                            <div class="mb-4 border-bottom pb-3">
                                <div class="d-flex justify-content-between">
                                    <h6 class="fw-bold mb-1">Ahmed R.</h6>
                                    <small class="text-muted">2 days ago</small>
                                </div>
                                <div class="text-warning small mb-2"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                                <p class="mb-0 text-muted">"This is the real deal. The scent is potent and lasts all day. The packaging was also very elegant."</p>
                            </div>
                            <!-- Single Review -->
                            <div class="mb-4 border-bottom pb-3">
                                <div class="d-flex justify-content-between">
                                    <h6 class="fw-bold mb-1">Sarah M.</h6>
                                    <small class="text-muted">1 week ago</small>
                                </div>
                                <div class="text-warning small mb-2"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i></div>
                                <p class="mb-0 text-muted">"Beautiful smell, very strong. Just a tiny drop is enough. Highly recommend for Jummah prayers."</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products -->
    <section class="py-5">
        <div class="container">
            <h3 class="text-center mb-5 font-arabic accent">You May Also Like</h3>
            <div class="row">
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="https://picsum.photos/seed/musk/400/400" class="card-img-top" alt="Musk">
                        <div class="card-body text-center">
                            <h6 class="fw-bold">White Musk</h6>
                            <span class="fw-bold text-success">$18.00</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="https://picsum.photos/seed/roseattar/400/400" class="card-img-top" alt="Rose">
                        <div class="card-body text-center">
                            <h6 class="fw-bold">Taif Rose</h6>
                            <span class="fw-bold text-success">$24.00</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="https://picsum.photos/seed/amber/400/400" class="card-img-top" alt="Amber">
                        <div class="card-body text-center">
                            <h6 class="fw-bold">Golden Amber</h6>
                            <span class="fw-bold text-success">$32.00</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="https://picsum.photos/seed/sandalwood/400/400" class="card-img-top" alt="Sandalwood">
                        <div class="card-body text-center">
                            <h6 class="fw-bold">Mysore Sandalwood</h6>
                            <span class="fw-bold text-success">$55.00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection